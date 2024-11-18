<?php

namespace App\Services\Models;

use App\Http\Resources\OptionResource;
use App\Models\Option;
use App\Services\Utils\paginatable;
use Illuminate\Database\Eloquent\Model;
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
}
