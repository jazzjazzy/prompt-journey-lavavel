@extends('layouts.app')

@section('content')

<div class="row justify-content-center w-1/2 m-auto">
    <div class="mt-16">

        <form id="payment-form" action="{{ route('subscribe.processSubscription') }}" method="POST">
            @csrf

            <div class="card">
                <div class="card-header">
                    You will be charged ${{ number_format($plan->price, 2) }} for {{ $plan->name }} Plan
                    <input type="hidden" name="plan-id" value="{{$plan->id}}">
                    @if($plan->id == 2)
                    <input type="hidden" name="payment-type" id="payment-type" value="one-time" >
                    @else
                    <input type="hidden" name="payment-type" id="payment-type" value="recurring">
                    @endif
                </div>

                <div class="card-body">

                    <input type="hidden" name="plan" id="plan" value="{{ $plan->id }}">
                    <div class="row">
                        <div class="col-xl-4 col-lg-4">
                            <div class="form-group">
                                <span for="name">Name</span>
                                <input type="text" name="name" id="card-holder-name" value="" autocomplete="no"
                                       placeholder="Name on the card">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-4 col-lg-4">
                            <div class="form-group">
                                <label>
                                    <span>Card number</span>
                                    <div id="card-number-element" class="field"></div>
                                </label>
                                <label>
                                    <span>Expiry date</span>
                                    <div id="card-expiry-element" class="field"></div>
                                </label>
                                <label>
                                    <span>CVC</span>
                                    <div id="card-cvc-element" class="field"></div>
                                </label>
                                <label>
                                    <span>Postal code</span>
                                    <input id="postal-code" name="postal_code" class="field"
                                           placeholder="Regular field placeholder"/>
                                </label>
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
                        <input type="hidden" name="payment_method" id="payment-method-id">
                        <button type="submit" class="btn btn-primary" id="submit-button"
                                data-secret="{{ $intent->client_secret }}">Purchase
                        </button>
                        <div id="error-message" class="text-danger"></div>

                    </div>
                </div>

        </form>

    </div>
</div>
</div>
</div>


<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ env('STRIPE_KEY') }}');

    var style = {
        base: {
            iconColor: '#666EE8',
            color: '#31325F',
            fontWeight: 300,
            fontFamily: 'Helvetica Neue',
            fontSize: '15px',

            '::placeholder': {
                color: '#CFD7E0',
            },
        },
    };

    const elements = stripe.elements()

    var cardNumberElement = elements.create('cardNumber', {
        style: style,
        placeholder: 'Custom card number placeholder',
    });
    cardNumberElement.mount('#card-number-element');

    var cardExpiryElement = elements.create('cardExpiry', {
        style: style,
        placeholder: 'Custom expiry date placeholder',
    });
    cardExpiryElement.mount('#card-expiry-element');

    var cardCvcElement = elements.create('cardCvc', {
        style: style,
        placeholder: 'Custom CVC placeholder',
    });
    cardCvcElement.mount('#card-cvc-element');

    function displayError(errorMessage) {
        const errorElement = document.getElementById('error-message');
        errorElement.textContent = errorMessage;
    }

    [cardNumberElement, cardExpiryElement, cardCvcElement].forEach(element => {
        element.on('change', event => {
            if (event.error) {
                displayError(event.error.message);
            } else {
                displayError('');
            }
        });
    });

    const form = document.getElementById('payment-form');
    const submitButton = document.getElementById('submit-button');
    const paymentMethodIdInput = document.getElementById('payment-method-id');

    form.addEventListener('submit', async (event) => {
            event.preventDefault();

            let paymentTypeInput = document.getElementById('payment-type').value;

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

