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

        <button id="card-button">直接訂閱</button>
    </form>

@endsection