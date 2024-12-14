<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\FeedBack\StoreFeedBackRequest;
use App\Services\Models\FeedBackModel;
use Illuminate\Http\Request;

class FeedBackController extends Controller
{

    public $feedBackModel;

    public function __construct(FeedBackModel $feedBackModel)
    {
        $this->feedBackModel = $feedBackModel;
    }

    public function store(StoreFeedBackRequest $request)
    {
        return $this->feedBackModel->sendFeedBack($request);
    }
}
