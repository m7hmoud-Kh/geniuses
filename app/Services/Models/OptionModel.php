<?php

namespace App\Services\Models;

use App\Http\Resources\OptionResource;
use App\Models\Option;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OptionModel extends Model
{

    public function getAllOptionByQuestionId($questionId)
    {
        $options = Option::where('question_id', $questionId)->get();
        if($options){
            return response()->json([
                'status' => "OK",
                'data' => OptionResource::collection($options)
            ]);
        }
        return response()->json([
            'message' => 'NOt found options for this question'
        ], Response::HTTP_NOT_FOUND);
    }

    public function storeOption(Request $request)
    {
        $data = $request->validated();
        $data['option'] = json_encode($request->option);
        $option = Option::create($data);

        return response()->json([
            'status' => Response::HTTP_CREATED,
            'data' => new OptionResource($option)
        ],Response::HTTP_CREATED);
    }

    public function showOption(Option $option)
    {
        return response()->json([
            'data' => new OptionResource($option)
        ]);
    }

    public function updateOption(Request $request, Option $option)
    {
        $data = $request->validated();
        $data['option'] = json_encode($request->option);
        $option->update($data);

        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
            'data' => new OptionResource($option)
        ], Response::HTTP_ACCEPTED);
    }

    public function destoryOption($option)
    {
        $option->delete();
        return response()->json([],Response::HTTP_NO_CONTENT);
    }

    public function destoryAllOptionByQuestionId($questionId)
    {
        Option::where('question_id', $questionId)->delete();
        return response()->json([],Response::HTTP_NO_CONTENT);
    }
}
