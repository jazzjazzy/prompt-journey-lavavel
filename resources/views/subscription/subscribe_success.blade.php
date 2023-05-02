@extends('layouts.app')

@section('content')

<div class="row justify-content-center w-1/4 m-auto">
    <div class="mt-16">

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">

                        <div class="text-center flex justify-center content-center mb-6">
                            <div><i class="fa-regular fa-circle-check text-green-500 text-9xl"></i></div>
                        </div>
                        <div class="flex justify-center content-center">
                            <div class="viewData w-1/2 mb-6">
                                <div class="viewItem">
                                    <div class="label">Purchased plan</div>
                                    <div class="data">{{ $plan->name }}</div>
                                </div>
                                <div class="viewItem">
                                    <div class="label">Price</div>
                                    <div class="data">${{ $plan->price }}</div>
                                </div>
                                <div class="viewItem">
                                    <div class="label">User</div>
                                    <div class="data">{{ $user->name }}</div>
                                </div>
                                <div class="viewItem">
                                    <div class="label">period</div>
                                    @if ($plan->abbreviation == 'Test')
                                            <div class="data">1 Month</div>
                                    @elseif ($plan->abbreviation == '/Month')
                                            <div class="data">Monthly</div>
                                    @elseif ($plan->abbreviation == '/Year')
                                            <div class="data">Yearly</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <p>Thank you for your payment. Your subscription has been activated.</p>
                        </div>
                    </div>
                    <div class="card-footer footer-right">
                        <a href="{{route('dashboard')}}" class="btn btn-primary text-center w-30 inline-block"
                           id="cancel-button">
                            @if ($plan->abbreviation == 'Test')
                                Go to dashboard
                            @else
                                Go to Projects
                            @endif
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
