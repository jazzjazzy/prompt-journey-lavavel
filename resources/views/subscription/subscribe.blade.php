@extends('layouts.app')

@section('content')

<div class="row justify-content-center w-1/2 m-auto">
    <div class="mt-16">

        <form id="payment-form" action="{{ route('subscribe.processSubscription') }}" method="POST">
            @csrf

            <div class="card">
                <div class="card-header">
                    The{{ $plan->name }} Plan
                    <input type="hidden" name="plan-id" value="{{$plan->id}}">
                    @if($plan->id == 2)
                    <input type="hidden" name="payment-type" id="payment-type" value="one-time" >
                    @else
                    <input type="hidden" name="payment-type" id="payment-type" value="recurring">
                    @endif
                </div>

                <div class="card-body">
                    <div class="grid grid-cols-12">
                        <div class="col-span-6 border-left-1">
                            <div class="pricing-free bg-blue-900 drop-shadow-lg text-gray-100 col-span-1 rounded-lg border-2
            border-gray-300 p-5 bg-gradient-to-r h-full">
                                <div class="heading w-full mx-auto font-bold text-2xl my-6">
                                    <h2 class="text-center">{{$plan->name}}</h2>
                                </div>
                                <div class="price text-6xl font-bold my-3 text-center">${{$plan->price}}
                                    <span class="text-sm">{{$plan->abbreviation}}</span>
                                </div>
                                <div class="description h-8 text-sm text-center">{{$plan->description}}</div>
                                <div class="list w-full p-4 my-auto  flex justify-center">
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

                        </div>
                        <div class="col-span-6 px-8">
                            <input type="hidden" name="plan" id="plan" value="{{ $plan->id }}">
                            <div class="row">
                                <div class="col-xl-4 col-lg-4">
                                    <div class="form-group">
                                        <span for="name">Name on card</span>
                                        <div>
                                            <input type="text" name="name" id="card-holder-name" class="w-full" value="" autocomplete="no"
                                                   placeholder="Name on the card">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-4 col-lg-4">
                                    <div class="form-group">
                                        <div>
                                            <span>Card number</span>
                                            <div id="card-number-element" class="field"></div>
                                        </div>
                                        <div class="grid grid-cols-2 gap-4">
                                        <div class="col-span-1">
                                            <span>Expiry date</span>
                                            <div id="card-expiry-element" class="field"></div>
                                        </div>
                                        <div class="col-span-1">
                                            <span>CVC</span>
                                            <div id="card-cvc-element" class="field"></div>
                                        </div>
                                        </div>
                                        <div>
                                            <span>Postal code</span>
                                            <div id="card-cvc-element" class="w-full field">
                                                <input type="text" id="postal-code" name="postal_code" class="w-full field"
                                                       placeholder="Postcode"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-center mt-1 h-5">
                                <div id="error-message" class="alert alert-notice text-danger"></div>
                            </div>
                            <div class="row">
                                <input type="hidden" name="payment_method" id="payment-method-id">
                                <button type="submit" class="btn btn-primary rounded-md w-full" id="submit-button"
                                        data-secret="{{ $intent->client_secret }}">Purchase
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card-footer footer-right">
                    <div class="col-xl-12 col-lg-12">
                        <a href="{{route('subscription.pricing')}}"
                           class="btn btn-primary text-center w-30 inline-block" id="cancel-button">
                            Cancel
                        </a>
                    </div>
                    @if(session('error'))
                    <div class="alert alert-error">{{ session('error') }}</div>
                    @endif
                </div>

        </form>

    </div>
</div>


<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ env('STRIPE_KEY') }}');

    var style = {
        base: {
            iconColor: '#666EE8',
            fontSize: '16px',
            fontFamily: 'Figtree, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"',
            lineheight: '1.5',
            '::placeholder': {
                color: '#CFD7E0',
            }
        },
        icon: {
            display: 'block',
            width: '30px',
            height: '20px',
            borderRadius: '4px',
        },
    };

    const elements = stripe.elements()

    var cardNumberElement = elements.create('cardNumber', {
        style: style,
        placeholder: 'Card Number',
        showIcon: true,
    });
    cardNumberElement.mount('#card-number-element');

    var cardExpiryElement = elements.create('cardExpiry', {
        style: style,
        placeholder: 'Card expiry date',
    });
    cardExpiryElement.mount('#card-expiry-element');

    var cardCvcElement = elements.create('cardCvc', {
        style: style,
        placeholder: 'CVC',
    });
    cardCvcElement.mount('#card-cvc-element');

    function displayError(errorMessage) {
        const errorElement = document.getElementById('error-message');
        errorElement.textContent = errorMessage;


        errorElement.style.display = 'block';
        errorElement.style.opacity = 0;
        setTimeout(() => {
            errorElement.style.transition = 'opacity 1s';
            errorElement.style.opacity = 1;
        }, 0);

        // Wait for 3 seconds before sliding the div from right to left
        setTimeout(() => {
            errorElement.style.transition = 'opacity 1s';
            errorElement.style.opacity = 0;
            setTimeout(() => {
                errorElement.style.display = 'none';
            }, 1000);
        }, 3000);
    }

    [cardNumberElement, cardExpiryElement, cardCvcElement].forEach(element => {
        element.on('change', event => {
            if (event.error) {
                displayError(event.error.message);
            }
        });
    });

    const form = document.getElementById('payment-form');
    const submitButton = document.getElementById('submit-button');
    const paymentMethodIdInput = document.getElementById('payment-method-id');

    form.addEventListener('submit', async (event) => {
            event.preventDefault();

            if(document.getElementById('card-holder-name').value == ''){
                displayError('Please enter card holder name');
                document.getElementById('card-holder-name').classList.add('payment-error');
                return false;
            }else if(document.getElementById('postal-code').value == ''){
                displayError('Please enter postal code');
                document.getElementById('card-holder-name').classList.remove('payment-error');
                document.getElementById('postal-code').classList.add('payment-error');
                return false;
            }else{
                document.getElementById('card-holder-name').classList.remove('payment-error');
                document.getElementById('postal-code').classList.remove('payment-error');
            }

                // Disable the submit button to prevent multiple submissions
                submitButton.disabled = true;

                // Create a Payment Method
                const {paymentMethod, error} = await stripe.createPaymentMethod({
                    type: 'card',
                    card: cardNumberElement,
                    billing_details: {
                        name: document.getElementById('card-holder-name').value,
                        address: {
                            postal_code: document.getElementById('postal-code').value,
                        },
                    },
                });

                if (error) {
                    // Show an error message
                    displayError(error.message);
                    submitButton.disabled = false;
                } else {
                    // Set the Payment Method ID in the hidden input field
                    paymentMethodIdInput.value = paymentMethod.id;

                    // Submit the form with the payment method ID
                    form.submit();
                }
            }
    );

</script>
@endsection

