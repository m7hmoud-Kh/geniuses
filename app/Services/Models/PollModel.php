<?php

namespace App\Services\Models;

use App\Http\Resources\PollResource;
use App\Models\Poll;
use App\Services\Utils\paginatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PollModel extends Model
{
    use paginatable;

    public function getAllPoll()
    {
        $polls = Poll::latest()->paginate();
        return response()->json([
            'Status' => Response::HTTP_OK,
            'data' => PollResource::collection($polls),
            'meta' => $this->getPaginatable($polls)
        ]);
    }

    public function getAllActivePoll()
    {
        $polls = Poll::Status()->get();
        return response()->json([
            'data' => PollResource::collection($polls)
        ]);
    }

    public function storePoll(Request $request)
    {
        $category = Poll::create($request->validated());
        return response()->json([
            'status' => Response::HTTP_CREATED,
            'data' => new PollResource($category)
        ],Response::HTTP_CREATED);
    }

    public function showPoll(Poll $poll)
    {
        return response()->json([
            'data' => new PollResource($poll)
        ]);
    }

    public function updatePoll(Request $request,Poll $poll)
    {
        $poll->update($request->validated());
        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
            'data' => new PollResource($poll)
        ], Response::HTTP_ACCEPTED);
    }

    public function destoryPoll($poll)
    {
        $poll->delete();
        return response()->json([],Response::HTTP_NO_CONTENT);
    }
}
