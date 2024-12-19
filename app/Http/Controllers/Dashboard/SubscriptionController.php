<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Models\SubscriptionModel;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public $subscriptionModel;
    public function __construct(SubscriptionModel $subscriptionModel)
    {
        $this->subscriptionModel = $subscriptionModel;
    }

    
}
