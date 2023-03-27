<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Exceptions\PaymentActionRequiredException;
use Laravel\Cashier\Exceptions\PaymentFailureException;
use App\Models\Plan;

class SubscriberController
{
    public function showSubscriptionForm(Plan $plan, Request $request)
    {
        $intent = auth()->user()->createSetupIntent();
        $user = Auth::user();
        return view('subscription.subscribe', compact("user", "plan", "intent"));
    }

    public function processSubscription(Request $request)
    {
        // Get the selected subscription plan from the form
        $plan = Plan::find($request->plan);

        // Get the authenticated user
        $user = Auth::user();
        try {
            // Create a new subscription for the user
            $user->newSubscription($request->plan, $plan->stripe_id)
                ->create($request->token);

            // Subscription created successfully, redirect to a success page
            return view("subscription.subscribe_success", compact('user', 'plan', 'request'));
        } catch (PaymentActionRequiredException $e) {
            // Payment action required, redirect to a payment page
            return redirect($e->payment->getHostedUrl())->withInput();
        } catch (PaymentFailureException $e) {
            // Payment failed, redirect back to the subscription page with an error message
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function cancelSubscription(Request $request)
    {

        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = Auth::user(); // Get the currently authenticated user
        $plan = $user->subscribedLastActivePlan(); // Check if the user is subscribed to a plan

        $user->subscription($plan->id)->cancel(); // Cancel the user's subscription in Stripe
        $user->subscription($plan->id)->stripe_status = 'canceled'; // Update the subscription status in your database
        $user->subscription($plan->id)->save(); // Save the changes to the database$request = {Illuminate\Http\Request}

        $endGracePeriod = null;
        if($user->subscription($plan->id)->onGracePeriod()){
            $endGracePeriod['date'] = $user->subscription($plan->id)->ends_at->format('Y-m-d');
            $endGracePeriod['plan'] = $plan->stripe_name;
        }

        return view("profile.edit", compact('user', 'endGracePeriod'));
    }

    public function resumeSubscription(Request $request)
    {

        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = Auth::user(); // Get the currently authenticated user
        $plan = $user->getSubscriptionPlan(); // Check if the user is subscribed to a plan

        // check the plan is the same as the one the user is subscribed to and if the user is on grace period
        if ($user->subscription($plan->id)->onGracePeriod()) {
            $user->subscription($plan->id)->resume(); // Cancel the user's subscription in Stripe
            $user->subscription($plan->id)->stripe_status = 'active'; // Update the subscription status in your database
            $user->subscription($plan->id)->save(); // Save the changes to the database
        } else {
            return back()->with('error', 'You are not subscribed to this plan');
        }
        return view("profile.edit", compact('user'));
    }
}
