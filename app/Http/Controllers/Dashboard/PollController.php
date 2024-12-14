<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Poll\StoreRequest;
use App\Http\Requests\Dashboard\Poll\UpdateRequest;
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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->pollModel->getAllPoll();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        return $this->pollModel->storePoll($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Poll $poll)
    {
        return $this->pollModel->showPoll($poll);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Poll $poll)
    {
        return $this->pollModel->updatePoll($request, $poll);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Poll $poll)
    {
        return $this->pollModel->destoryPoll($poll);
    }
}
