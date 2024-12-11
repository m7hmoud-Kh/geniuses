<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Services\Models\LessonModel;
use Illuminate\Http\Request;

class LessonController extends Controller
{

    public $lessonModel;
    public function __construct(LessonModel $lessonModel)
    {
        $this->lessonModel = $lessonModel;
    }

    public function show(Request $request)
    {
        return $this->lessonModel->showActiveLesson($request);
    }
}
