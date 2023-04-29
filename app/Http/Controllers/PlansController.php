<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class PlansController extends Controller
{
    public function index()
    {
        $plans = Plan::all();
        $user = auth()->user();

        $plan = $user->subscribedLastActivePlan();
        $subscribed = $plan ? $plan->name : null;

        return view('subscription.pricing', compact('plans', 'subscribed'));
    }

    public function modal()
    {
        $plans = Plan::all();
        $user = auth()->user();

        $plan = $user->subscribedLastActivePlan();
        $subscribed = $plan ? $plan->name : null;

        return view('subscription.pricingmodal', compact('plans', 'subscribed'));
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show(Plan $plan)
    {
        $intent = auth()->user()->createSetupIntent();
        return view('subscription.subscribe', compact('plan', 'intent'));
    }

    public function edit(Plan $plan)
    {
    }

    public function update(Request $request, Plan $plan)
    {
    }

    public function destroy(Plan $plan)
    {
    }
}
