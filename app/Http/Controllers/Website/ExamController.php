<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\Exam\SubmitExamRequest;
use App\Http\Requests\Website\Exam\SubmitFlashExamRequest;
use App\Http\Requests\Website\Exam\SubmitMcqExamRequest;
use App\Http\Requests\Website\Exam\SubmitTableExamRequest;
use App\Models\Exam;
use App\Services\Models\ExamModel;
use Illuminate\Http\Request;

class ExamController extends Controller
{

    public $examModel;

    public function __construct(ExamModel $examModel)
    {
        $this->examModel = $examModel;
    }

    public function show(Request $request)
    {
        return $this->examModel->previewExam($request->module_id, $request->exam_id);
    }


    public function submitExam(Request $request)
    {
        $exam = Exam::Status()->where('module_id',$request->module_id)->findOrFail($request->exam_id);
        switch ($exam->type) {
            case 'mcq':
                $validatedRequest = SubmitMcqExamRequest::createFrom($request);
                return $this->examModel->submitMcqExam($validatedRequest, $exam);
            case 'flash':
                $validatedRequest = SubmitFlashExamRequest::createFrom($request);
                return $this->examModel->submitFlashExam($validatedRequest, $exam);
            case 'table':
                $validatedRequest = SubmitTableExamRequest::createFrom($request);
                return $this->examModel->submitTableExam($validatedRequest, $exam);
            default:
                break;
        }
    }
}
