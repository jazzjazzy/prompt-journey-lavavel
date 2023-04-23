<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SubscriptionMiddleware
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        // Check if user has an active subscription
        if (!$user->isSubscribed()) {
            // Redirect to subscription page or return error response
            return redirect()->route('subscription.pricing');
        }

        return $next($request);
    }
}
