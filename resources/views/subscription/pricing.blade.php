@extends('layouts.app')

@section('content')
<form action="/subscribe" method="POST">
    @csrf
    <div class="plan text-4xl text-center my-9 boldest">Choose a subscription plan</div>
    <div class="Pricing grid grid-cols-4 w-3/4 mx-auto gap-5">
        @foreach ($plans as $plan)

        <div
            class="pricing-free bg-blue-900 drop-shadow-lg text-gray-100 col-span-1 rounded-lg border-2 border-gray-300 p-5 @if ($plan->abbreviation == '/Year') hidden @endif bg-gradient-to-r from-indigo-500 via-blue-500 to-indigo-500">
            <div class="heading w-full mx-auto font-bold text-2xl my-6">
                <h2 class="text-center">{{$plan->name}}</h2>
            </div>
            <div class="price text-6xl font-bold my-3 text-center">${{$plan->price}}
                <span class="text-sm">{{$plan->abbreviation}}</span>
            </div>
            <div class="description h-12 min-h-max">{{$plan->description}}</div>
            <div class="list w-full p-4 my-auto">
                <ul>

                    @php
                    $arrayData = json_decode($plan->metaData, true);
                    @endphp

                    @foreach ( $arrayData as $data)
                        <li class="text-xs">
                            @if ($data['checked'] == 'true')
                                <i class="w-[1rem] h-[1rem] fa-sharp fa-solid fa-check fa-beat-fade text-lime-400"></i>
                            @else
                                <i class="w-[1rem] h-[1rem] fa-sharp fa-solid fa-x text-red-500"></i>
                            @endif
                            {{$data['text']}}
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="list p-4 my-auto flex justify-center">
                @if ($plan->abbreviation == 'Free')
                    @if(auth()->check())
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary text-center">Free</a>
                    @else
                        <a href="{{ url('/register') }}" class="btn btn-primary text-center">Register</a>
                    @endif
                @else
                    @if (!$subscribed)
                        <a href="{{ route('subscription.subscribe', $plan->slug ) }}" class="btn btn-primary text-center">Pay Now</a>
                    @else
                        <a href="{{ route('subscription.subscribe', $plan->slug ) }}" class="btn btn-primary text-center">upgrade</a>
                    @endif
                @endif
            </div>
        </div>
        @endforeach
    </div>

</form>
@endsection
