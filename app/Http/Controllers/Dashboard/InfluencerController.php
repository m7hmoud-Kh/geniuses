<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Influencer\StoreInfluencerRequest;
use App\Http\Requests\Dashboard\Influencer\UpdateInfluencerRequest;
use App\Models\Influencer;
use App\Services\Models\InfluencerModel;
use Illuminate\Http\Request;

class InfluencerController extends Controller
{
    public $influencerModel;

    public function __construct(InfluencerModel $influencerModel)
    {
        $this->influencerModel = $influencerModel;
    }

    public function index()
    {
        return $this->influencerModel->getAllInfluencer();
    }

    public function show(Influencer $influencer)
    {
        return $this->influencerModel->showInfluencer($influencer);
    }

    public function store(StoreInfluencerRequest $request)
    {
        return $this->influencerModel->storeInfluencer($request);
    }

    public function update(UpdateInfluencerRequest $request, Influencer $influencer)
    {
        return $this->influencerModel->updateInfluencer($request, $influencer);
    }

    public function destroy(Influencer $influencer)
    {
        return $this->influencerModel->destoryInfluencer($influencer);
    }
}
