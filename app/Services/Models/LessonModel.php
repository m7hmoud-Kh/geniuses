<?php

namespace App\Services\Models;

use App\Http\Resources\LessonResource;
use App\Models\Lesson;
use App\Services\Utils\paginatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LessonModel extends Model
{
    use paginatable;

    public function getAllLessons($moduleId)
    {
        $lessons = Lesson::with('module')->where('module_id',$moduleId)->latest()->paginate();
        return response()->json([
            'Status' => Response::HTTP_OK,
            'data' => LessonResource::collection($lessons),
            'meta' => $this->getPaginatable($lessons)
        ]);
    }

    public function storeLesson(Request $request)
    {
        $exam = Lesson::create($request->validated());
        return response()->json([
            'status' => Response::HTTP_CREATED,
            'data' => new LessonResource($exam)
        ],Response::HTTP_CREATED);
    }

    public function showLesson(Lesson $lesson)
    {
        $lesson = $lesson->load(['module']);
        return response()->json([
            'data' => new LessonResource($lesson)
        ]);
    }

    public function updateLesson(Request $request, Lesson $lesson)
    {
        $lesson->update($request->validated());
        return response()->json([
            'status' => Response::HTTP_ACCEPTED,
            'data' => new LessonResource($lesson)
        ], Response::HTTP_ACCEPTED);
    }

    public function destoryLesson($lesson)
    {
        $lesson->delete();
        return response()->json([],Response::HTTP_NO_CONTENT);
    }

}
