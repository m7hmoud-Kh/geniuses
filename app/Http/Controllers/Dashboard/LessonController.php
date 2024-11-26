<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Lesson\StoreLessonRequest;
use App\Http\Requests\Dashboard\Lesson\UpdateLessonRequest;
use App\Models\Lesson;
use App\Services\Models\LessonModel;
use Illuminate\Http\Request;

class LessonController extends Controller
{

    public $lessonModel;

    public function __construct(LessonModel $lessonModel)
    {
        $this->lessonModel = $lessonModel;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->lessonModel->getAllLessons($request->module_id);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLessonRequest $request)
    {
        return $this->lessonModel->storeLesson($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Lesson $lesson)
    {
        return $this->lessonModel->showLesson($lesson);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLessonRequest $request, Lesson $lesson)
    {
        return $this->lessonModel->updateLesson($request, $lesson);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lesson $lesson)
    {
        return $this->lessonModel->destoryLesson($lesson);
    }
}
