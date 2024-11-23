<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Exam\StoreExamRequest;
use App\Http\Requests\Dashboard\Exam\UpdateExamRequest;
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

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->examModel->getAllExams($request->moduleId);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExamRequest $request)
    {
        return $this->examModel->storeExam($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Exam $exam)
    {
        return $this->examModel->showExam($exam);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExamRequest $request, Exam $exam)
    {
        return $this->examModel->updateExam($request, $exam);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exam $exam)
    {
        return $this->examModel->destoryExam($exam);
    }
}
