<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\Subscription\StoreSubscriptionRequest;
use App\Http\Resources\SubscriptionResource;
use App\Models\Category;
use App\Models\Module;
use App\Services\Models\SubscriptionModel;
use App\Services\Utils\StripePayment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SubscriptionController extends Controller
{
    public function createPaymentIntent(StoreSubscriptionRequest $request,StripePayment $stripePayment, SubscriptionModel $subscriptionModel)
    {
        $subscription = $subscriptionModel->storeSubscription($request);
        $paymentIntent = $stripePayment->createPaymentIntent($stripePayment->getAmountInCent($request));

        return response()->json([
            'clientSecret' => $paymentIntent->client_secret,
            'amount_in_cent' => $stripePayment->getAmountInCent($request),
            'subscription' => new SubscriptionResource($subscription)
        ], Response::HTTP_CREATED);
    }
}
