<?php

namespace App\Http\Controllers;

use DebugBar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Exceptions\IncompletePayment;
use Laravel\Cashier\Exceptions\SubscriptionUpdateFailure;
use App\Models\Plan;
use App\Models\Project;
use Laravel\Cashier\Subscription;

class SubscriberController
{
    /**
     * @param Plan $plan
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showSubscriptionForm(Plan $plan, Request $request)
    {
        $intent = auth()->user()->createSetupIntent();
        $user = Auth::user();
        return view('subscription.subscribe', compact("user", "plan", "intent"));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function processSubscription(Request $request)
    {
        // Get the selected subscription plan from the form
        $plan = Plan::find($request->plan);
        // Get the authenticated user
        $user = Auth::user();

        //get the country of the user for tax purposes or set to AU for testing
        if(env('APP_ENV') == 'production'){
            $country = $user->getUserCountry($request);
        }else{
            $country = 'AU';
        };

        $userPlan = $user->getPlanFromUserSubscription();

        $paymentMethod = $request->get('payment_method');
        $paymentType = $request->get('payment-type');

        if ($paymentType === 'one-time') {
            return $this->processOneTimePayment($user, $plan, $paymentMethod, $request);
        } else {

            // Check if the user already has a Stripe customer ID
            if (!$user->stripe_id) {
                // Create the Stripe customer
                $user->createAsStripeCustomer();
            }

            try {
                // Check if the user already has a subscription and it is not a Tester plan
                if ($userPlan instanceof Plan && $userPlan->stripe_name !== 'Tester Plan') {
                    // if user already has a subscription, swap it
                    return $this->processSwapSubscription($user, $plan, $userPlan, $request);
                }else {
                    // if user does not have a subscription, create one
                    return $this->processRecurringSubscription($user, $plan, $userPlan, $paymentMethod, $request, $country);
                }
            } catch (SubscriptionUpdateFailure $e) {
                // Payment action required, redirect to a payment page
                return redirect($e->payment->getHostedUrl())->withInput();
            } catch (IncompletePayment $e) {
                // Payment failed, redirect back to the subscription page with an error message
                return back()->with('error', $e->getMessage())->withInput();
            }
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
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

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function resumeSubscription(Request $request)
    {

        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = Auth::user(); // Get the currently authenticated user
        $plan = $user->getPlanFromUserSubscription(); // Check if the user is subscribed to a plan

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


    /**
     * We are doing a one-time payment here, so we need to create a PaymentIntent
     * This is for the Tester account type
     * This is a one time payment that will not be prorated or refunded
     * @param $user
     * @param $plan
     * @param $paymentMethod
     * @param $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    private function processOneTimePayment($user, $plan, $paymentMethod, $request){
        try {
            // Create a new customer or update the existing customer
            $user->createOrGetStripeCustomer([
                'email' => $user->email,
                'payment_method' => $paymentMethod,
            ]);

            // Charge the customer using the provided payment method
            $user->charge($plan->price * 100, $paymentMethod, [
                'currency' => 'usd',
                'description' => 'One-Time Payment',
            ]);

            // Save the project
            $project = new Project(['name' => 'Tester', 'description' => 'Your tester project']);
            $user->projects()->save($project);

            // Create a new subscription record in the subscriptions table with a custom end date (1 month from now)
            $subscription = $user->subscriptions()->create([
                'name' => $plan->stripe_name,
                'stripe_id' => 'one-time-payment-' . $user->id, // No Stripe subscription for a one-time payment
                'stripe_status' => 'active',
                'stripe_price' => $plan->stripe_id,
                'quantity' => 1,
                'trial_ends_at' => null,
                'ends_at' => now()->addMonth(),
            ]);

            return view("subscription.subscribe_success", compact('user', 'plan', 'request'));
        } catch (SubscriptionUpdateFailure $e) {
            // Payment action required, redirect to a payment page
            return redirect($e->payment->getHostedUrl())->withInput();
        } catch (IncompletePayment $e) {
            // Payment failed, redirect back to the subscription page with an error message
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    /**
     * we are checking if the user has a subscription plan already
     * and if the user has a subscription plan already, we are swapping the plan
     * to the new plan selected
     * ignore the tester plan as this is paid for with a one-time payment
     * swap will update Stripe with the new plan and prorate the difference
     *
     * @param $user
     * @param $plan
     * @param $userPlan
     * @param $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws IncompletePayment
     * @throws SubscriptionUpdateFailure
     */
    private function processSwapSubscription($user, $plan, $userPlan, $request){
        $subscription = $user->subscription($userPlan->stripe_name);

        if ($subscription instanceof Subscription) {
            $subscription->swap($plan->stripe_id);
        }

        $subscription->update([
            'name' => $plan->stripe_name,
        ]);

        //todo: add web hooks to handle subscription changes rl:3

        // Subscription created successfully, redirect to a success page
        return view("subscription.subscribe_success", compact('user', 'plan', 'request'));
    }


    /**
     * if the user does not have a subscription plan already
     * then we create a new customer and a new subscription for the user
     * and we also create a Default project for the user
     *
     * @param $user
     * @param $plan
     * @param $userPlan
     * @param $paymentMethod
     * @param $request
     * @param $country
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    private function processRecurringSubscription($user, $plan, $userPlan,$paymentMethod, $request, $country)
    {


        // Create a new customer
        $user->updateStripeCustomer([
            'address' => [
                'postal_code' => $request->get('postal_code'),
                'country' => $country,
            ],
        ]);

        // Create a new subscription for the user
        $user->newSubscription($plan->stripe_name, $plan->stripe_id)
            ->create($paymentMethod, [
                'name' => $request->get('name'),
                'email' => $user->email,
                'payment_method' => $paymentMethod,
            ]);

        $project = new Project(['name' => 'Default', 'description' => 'My first project']);
        $user->projects()->save($project);

        //todo: add web hooks to handle subscription changes rl:3

        /***
         * if the user had a tester Plan plan already we to make the plan inactive
         */
        if ($userPlan instanceof Plan && $userPlan->stripe_name === 'Tester Plan') {
            $subscription = $user->subscription($userPlan->stripe_name);
            $subscription->update([
                'stripe_status' => 'inactive',
            ]);
        }

        // Subscription created successfully, redirect to a success page
        return view("subscription.subscribe_success", compact('user', 'plan', 'request'));
    }
}
