<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Exception;
use Stripe\Stripe;
use Stripe\Customer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\ApiErrorException;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     *
     * @param Request $request
     * @return View
     */
    public function edit(Request $request): View
    {
        try {
            $user = auth()->user();
            $plan = $user->getPlanFromUserSubscription();
            $endGracePeriod = null;

            if (is_null($plan)) {
                $plan = $user->getPlanFromUserGracePeriod();
            }

            if ($plan !== null) {
                $subscription = $user->subscription($plan->stripe_name);
                if ($subscription->onGracePeriod()) {
                    $endGracePeriod['date'] = $user->subscription($plan->stripe_name)->ends_at->format('Y-m-d');
                    $endGracePeriod['plan'] = $plan->stripe_name;
                }
            }

            return view('profile.edit', [
                'user' => $request->user(),
                'endGracePeriod' => $endGracePeriod,
            ]);
        } catch (Exception $e) {
            return redirect()->back()->with('error-edit', $e->getMessage())->withInput();
        }
    }

    /**
     * Update the user's profile information.
     * @param ProfileUpdateRequest $request
     * @return RedirectResponse
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->password !== null) {
            $request->validateWithBag('userDeletion', [
                'password' => ['required', 'current-password'],
            ]);
        }

        if ($user->isSubscribed()) {
            // if user is subscribed and deleteing account, cancel subscription and delete stripe customer
            try {
                // cancel only subscription, Test Plan has no subscription so check for that
                if ($user->getPlanFromUserSubscription()->stripe_name !== "Tester Plan") {
                    $user->subscription($user->getPlanFromUserSubscription()->stripe_name)->cancel();
                }
                //delete stripe customer
                Stripe::setApiKey(env('STRIPE_SECRET'));
                Customer::retrieve(Auth::user()->stripeId())->delete();
            } catch (ApiErrorException $e) {
                $uniqueId = Str::uuid()->toString(); // generate unique id
                Log::error('Stripe-Api-Error :: ' . $uniqueId . ' :: ' . $e->getMessage()); // log error with unique id
                // return error message to user with unique id
                return redirect()->back()->with('error-destroy', 'There was a problem deleting customer subscription stripe details :: error uuid - ' . $uniqueId)->withInput();
            } catch (Exception $e) {
                $uniqueId = Str::uuid()->toString(); // generate unique id
                Log::error('Exception :: ' . $uniqueId . ' :: ' . $e->getMessage()); // log error with unique id
                // return error message to user with unique id
                return redirect()->back()->with('error-destroy', 'There was a problem deleting customer subscription stripe details :: error uuid - ' . $uniqueId)->withInput();
            }
        }

        // logout user and delete account
        Auth::logout();

        // delete user
        $user->delete();

        // invalidate session and regenerate token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
