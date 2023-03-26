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
        return view('subscription.subscribe',  compact("user","plan", "intent"));
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
            return view("subscription.subscribe_success");
        } catch (PaymentActionRequiredException $e) {
            // Payment action required, redirect to a payment page
            return redirect($e->payment->getHostedUrl())->withInput();
        } catch (PaymentFailureException $e) {
            // Payment failed, redirect back to the subscription page with an error message
            return back()->with('error', $e->getMessage())->withInput();
        }
    }
}
