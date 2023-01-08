<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// webhook
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;

class WebhookController extends CashierController
{
    public function handleInvoicePaymentSucceed(){
        echo "Invoice Payment Succeed!";
    }
}
