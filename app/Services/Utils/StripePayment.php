<?php

namespace App\Services\Utils;

use App\Models\Category;
use App\Models\Module;
use Illuminate\Http\Request;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class StripePayment
{
    public function createPaymentIntent($amount)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        return PaymentIntent::create([
            'amount' => $amount,
            'currency' => 'usd',
            'metadata' => ['integration_check' => 'accept_a_payment'],
        ]);
    }

    public function getAmountInCent(Request $request)
    {
        if(isset($request->category_id)){
            $amount = Category::whereId($request->category_id)->first()->price;
        }else {
            $amount = Module::whereId($request->module_id)->first()->price;
        }
        return $amount * 100;
    }

}
