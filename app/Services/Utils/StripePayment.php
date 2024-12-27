<?php

namespace App\Services\Utils;

use App\Models\Category;
use App\Models\Module;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
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

    public function createPaymentLink($invoiceData)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $invoiceData->name, // E.g., "Invoice #12345"
                    ],
                    'unit_amount' => $invoiceData->price * 100, // Convert to cents
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => url('/payment/success'),
            'cancel_url' => url('/payment/cancel'),
        ]);
        return $session->url;
    }

}
