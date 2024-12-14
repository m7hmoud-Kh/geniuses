<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\PollResource;
use App\Models\Poll;
use App\Services\Models\PollModel;
use Illuminate\Http\Request;

class PollController extends Controller
{

    public $pollModel;

    public function __construct(PollModel $pollModel)
    {
        $this->pollModel = $pollModel;
    }

    public function index()
    {
        return $this->pollModel->getAllActivePoll();
    }
}
