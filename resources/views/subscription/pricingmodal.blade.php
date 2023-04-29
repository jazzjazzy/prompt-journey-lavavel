@extends('layouts.modal')

@section('content')
<form action="/subscribe" method="POST">
    @csrf
    <div class="plan text-4xl text-center my-9 boldest">Choose a subscription plan</div>
    <div class="flex justify-center mb-3">
        <span class="text-md px-3">Monthly</span>
        <label for="toggle" class="toggle-switch bg-blue-200 cursor-pointer relative w-12 h-6 rounded-full">
            <input type="checkbox" id="toggle" class="sr-only peer">
            <span class="w-2/5 h-4/5 bg-blue-400 absolute rounded-full left-1 top-0.5 peer-checked:bg-blue-600
        peer-checked:left-6 transition-all duration-500"></span>
        </label>
        <span class="text-md px-3">Yearly</span>
    </div>
    <div class="flex justify-center mb-3 p-0 m-0 h-6"><span id="savings"
                                                            class="hidden">Save 1 month when you pay yearly</span></div>

    <div class="Pricing grid grid-cols-4 w-3/4 mx-auto gap-5">
        @foreach ($plans as $plan)
        <div
            class="pricing-free bg-blue-900 drop-shadow-lg text-gray-100 col-span-1 rounded-lg border-2
            border-gray-300 p-5 bg-gradient-to-r
            @if ($plan->name == $subscribed ) from-amber-500 via-orange-500 to-amber-500 @else from-blue-500 via-blue-500 to-blue-500 @endif
            @if ($plan->abbreviation == '/Year') yearly hidden @elseif(($plan->abbreviation == '/Month')) monthly @endif ">
            <div class="heading w-full mx-auto font-bold text-2xl my-6">
                <h2 class="text-center">{{$plan->name}}</h2>
            </div>
            <div class="price text-6xl font-bold my-3 text-center">${{$plan->price}}
                <span class="text-sm">{{$plan->abbreviation}}</span>
            </div>
            <div class="description h-16 text-sm text-">{{$plan->description}}</div>
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
        </div>
        @endforeach
    </div>

</form>
<script type="module">

    $(document).ready(function () {
        const toggleSwitch = $('#toggle');
        const div1 = $('.monthly');
        const div2 = $('.yearly');
        const savings = $('#savings');

        // check if toggle is checked on page load
        if (toggleSwitch.prop('checked')) {
            div1.removeClass('block');
            div1.addClass('hidden');
            div2.removeClass('hidden');
            div2.addClass('block');
            savings.addClass('block');
            savings.removeClass('hidden');
        }


        toggleSwitch.on('change', function () {

            if (toggleSwitch.prop('checked')) {
                div1.removeClass('block');
                div1.addClass('hidden');
                div2.removeClass('hidden');
                div2.addClass('block');
                savings.addClass('block');
                savings.removeClass('hidden');
            } else {
                div2.removeClass('block');
                div2.addClass('hidden');
                div1.removeClass('hidden');
                div1.addClass('block');
                savings.removeClass('block');
                savings.addClass('hidden');
            }
        });
    });

</script>

@endsection
