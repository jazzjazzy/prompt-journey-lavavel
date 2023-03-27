@extends('layouts.app')

@section('content')

<div class="row justify-content-center w-1/2 m-auto">
    <div class="mt-16">

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        SUCCESS !!!!
                    </div>
                    <div class="card-body">
                        <div class="viewData mb-6">
                            <div class="viewItem">
                                <div class="label">purchased plan</div>
                                <div class="data">{{ $plan->name }}</div>
                            </div>
                            <div class="viewItem">
                                <div class="label">price</div>
                                <div class="data">${{ $plan->price }}</div>
                            </div>
                            <div class="viewItem">
                                <div class="label">user</div>
                                <div class="data">{{ $user->name }}</div>
                            </div>
                            <div class="viewItem">
                                <div class="label">period</div>
                                <div class="data">{{$plan->abbreviation}}</div>
                            </div>
                        </div>

                        <p>Thank you for your payment. Your subscription has been activated.</p>
                    </div>
                    <div class="card-footer footer-right">
                        <a href="{{route('dashboard')}}" class="btn btn-primary text-center w-30 inline-block"
                           id="cancel-button">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
