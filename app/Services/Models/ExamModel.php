<?php

namespace App\Services\Models;

use App\Http\Resources\ExamResource;
use App\Models\Exam;
use App\Services\Utils\paginatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ExamModel extends Model
{
    use paginatable;

    public function getAllExams($moduleId)
    {
        $exams = Exam::with('module')->where('module_id',$moduleId)->latest()->paginate();
        return response()->json([
            'Status' => Response::HTTP_OK,
            'data' => ExamResource::collection($exams),
            'meta' => $this->getPaginatable($exams)
        ]);
    }

    public function storeExam(Request $request)
    {
        $exam = Exam::create($request->validated());
        return response()->json([
            'status' => Response::HTTP_CREATED,
            'data' => new ExamResource($exam)
        ],Response::HTTP_CREATED);
    }

    public function showExam(Exam $exam)
    {
        $exam = $exam->load(['module']);
        return response()->json([
            'data' => new ExamResource($exam)
        ]);
    }

    public function updateExam(Request $request, Exam $exam)
    {
        $exam->update($request->validated());
        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
            'data' => new ExamResource($exam)
        ], Response::HTTP_ACCEPTED);
    }

    public function destoryExam($exam)
    {
        $exam->delete();
        return response()->json([],Response::HTTP_NO_CONTENT);
    }


}
