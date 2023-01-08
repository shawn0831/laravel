@extends('layouts.app')

@section('content')
    <!-- <form action="/order" method="post">
        {{csrf_field()}}

        <div>產品1</div>
        <input name="name" type="hidden" value="產品1">

        <div>數量</div>
        <input name="quantity" type="number" value="">

        <div>信用卡Token</div>
        <input name="creditCardToken" type="text" value="">

        <input type="submit">
    </form> -->

    <style>
        .StripeElement {
            box-sizing: border-box;

            height: 40px;

            padding: 10px 12px;

            border: 1px solid transparent;
            border-radius: 4px;
            background-color: white;

            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;

            /* 自訂 */
            width:500px;
        }

        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }

        .StripeElement--invalid {
            border-color: #fa755a;
        }

        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }

        .CardField-child{
            width:100px !important;
        }
    </style>

    <form action="/order" method="post" id="payment-form">
        {{csrf_field()}}

        <div class="form-row">
            <label for="holder-name">持卡人姓名</label>
            <input id="holder-name" name="holder-name" type="text">
        </div>

        <div class="form-row">
            <label for="phone">手機號碼</label>
            <input id="phone" name="phone" type="text">
        </div>

        <div class="form-row">
            <label for="country">國家</label>
            <input id="country" name="country" type="text">
        </div>

        <div class="form-row">
            <label for="city">城市</label>
            <input id="city" name="city" type="text">
        </div>

        <div class="form-row">
            <label for="address">地址</label>
            <input id="address" name="address" type="text">
        </div>

        <div class="form-row">
            <label for="card-element">信用卡卡號</label>
            <div id="card-element">
                <!-- A Stripe Element will be inserted here. -->
            </div>
        </div>

        <div class="form-row">
            <div id="card-errors" role="alert"></div>
        </div>

        <button id="card-button" data-secret="{{isset($intent)? $intent->client_secret:''}}">Submit Payment</button>
    </form>

    @if(isset($intent))
        <!-- 如果使用setupItent蒐集付款資訊，則需要把$intent->client_secret作為attribute或hidden input置入表單中 -->
        <!-- {{$intent}} -->
    @endif

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        // 設置stripe element於表單中
        // ================================================================
        var stripe = Stripe('pk_test_yAggJnGXIFSQo8rbxKbGvu0U00gP9WWGE3'); // stripe-public-key
        var elements = stripe.elements();

        var style = {
            base: {
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };

        var card = elements.create('card', {style: style});
        card.mount('#card-element');

        card.addEventListener('change', function(event) {
            var displayError = document.getElementById('card-errors');

            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        // 範例-獲取token
        // ================================================================
        // 提交付款資訊於stripe，並接收token
        // var form = document.getElementById('payment-form');
        // form.addEventListener('submit', function(event) {
        //     // 阻擋提交動作
        //     event.preventDefault();

        //     stripe.createToken(card).then(function(result){
        //         if (result.error) {
        //             var errorElement = document.getElementById('card-errors');
        //             errorElement.textContent = result.error.message;
        //         } else {
        //             // 將token提交給server
        //             stripeTokenHandler(result.token.id);
        //         }
        //     });
        // });

        function stripeTokenHandler(token) {
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token);
            form.appendChild(hiddenInput);

            form.submit();
        }

        // 長期儲存付款資訊(使用setupIntent認證，token可重複使用，且會長期保存)
        // ================================================================
        const holderName = document.getElementById('holder-name');
        const phone = document.getElementById('phone');
        const country = document.getElementById('country');
        const city = document.getElementById('city');
        const address = document.getElementById('address');

        const cardButton = document.getElementById('card-button');
        const errorElement = document.getElementById('card-errors');
        const clientSecret = cardButton.dataset.secret;

        cardButton.addEventListener('click', async (e) => {
            // 阻擋提交動作
            e.preventDefault();

            const { setupIntent, error } = await stripe.handleCardSetup(
                clientSecret, card, {
                    payment_method_data: {
                        billing_details: {
                            'name': holderName.value,
                            'phone': phone.value,
                            'address': {
                                'country': country.value,
                                'city': city.value,
                                'line1': address.value,
                            }
                        }
                    }
                }
            );

            if (error) {
                // Display "error.message" to the user...
                errorElement.textContent = error.message;
            }else {
                // The card has been verified successfully...
                $token = setupIntent.payment_method
                stripeTokenHandler($token);
            }
        });

        // 獲取一次使用的token (獲得的token只能使用一次，且只在幾分鐘內有效)
        // ================================================================
        // const cardHolderName = document.getElementById('card-holder-name');
        // const cardButton = document.getElementById('card-button');
        // const errorElement = document.getElementById('card-errors');

        // cardButton.addEventListener('click', async (e) => {
        //     // 阻擋提交動作
        //     e.preventDefault();

        //     const { paymentMethod, error } = await stripe.createPaymentMethod(
        //         'card', card, {
        //             billing_details: { name: cardHolderName.value }
        //         }
        //     );

        //     if (error) {
        //         // Display "error.message" to the user...
        //         errorElement.textContent = error.message;
        //     } else {
        //         // The card has been verified successfully...
        //         $token = paymentMethod.id;
        //         stripeTokenHandler($token);
        //     }
        // });

    </script>
@endsection