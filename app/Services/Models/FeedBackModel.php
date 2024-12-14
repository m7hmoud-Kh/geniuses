<?php

namespace App\Services\Models;

use App\Models\Feedback;
use App\Models\Poll;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class FeedBackModel extends Model
{
    public function sendFeedBack(Request $request)
    {
        foreach ($request->polls as $pollId => $rate) {
            if(Poll::Status()->whereId($pollId)->exists()){
                Feedback::create([
                    'user_id' => Auth::user()->id,
                    'module_id' => $request->module_id,
                    'poll_id' => $pollId,
                    'rate' => $rate
                ]);
            }
        }

        return response()->json([
            'message' => 'Thanks for your Feedback',
        ], Response::HTTP_CREATED);
    }
}
