<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Cashier::calculateTaxes();

        //if login user is tester, then show hoe many days left before expire
        View::composer('layouts.navigation', function ($view) {
            $user = auth()->user();
            $plan = null;
            $daysTillExpire = null;
            if ($user) {
                // Assuming you have a method to retrieve the user's plan in the User model
                $plan = $user->getPlanFromUserSubscription();
                if ($plan && $plan->name == 'Tester') {
                    $subscription = $user->subscription($plan->stripe_name);
                    if ($subscription) {
                        $endDate = Carbon::parse($subscription->trial_ends_at);
                        $now = Carbon::now();
                        $daysTillExpire = $now->diffInDays($endDate, false);
                    }
                }
            }

            $view->with(['plan'=> $plan, 'daysTillExpire'=> $daysTillExpire]);
        });
    }
}
