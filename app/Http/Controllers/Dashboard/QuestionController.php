<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Question\StoreQuestionRequest;
use App\Http\Requests\Dashboard\Question\UpdateQuestionRequest;
use App\Models\Question;
use App\Services\Models\QuestionModel;

class QuestionController extends Controller
{
    public $questionModel;
    public function __construct(QuestionModel $questionModel)
    {
        $this->questionModel = $questionModel;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->questionModel->getAllQuestion();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuestionRequest $request)
    {
        return $this->questionModel->storeQuestion($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        return $this->questionModel->showQuestion($question);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuestionRequest $request, $questionId)
    {
        return $this->questionModel->updateQuestion($request, $questionId);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        return $this->questionModel->destoryQuestion($question);
    }
}
