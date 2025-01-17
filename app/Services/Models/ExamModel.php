<?php

namespace App\Services\Models;

use App\Http\Requests\Website\Exam\SubmitExamRequest;
use App\Http\Requests\Website\Exam\SubmitFlashExamRequest;
use App\Http\Requests\Website\Exam\SubmitMcqExamRequest;
use App\Http\Requests\Website\Exam\SubmitTableExamRequest;
use App\Http\Resources\ExamResource;
use App\Http\Resources\ExamResultResource;
use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\Question;
use App\Services\Utils\Paginatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ExamModel extends Model
{
    use Paginatable;

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

    public function previewExam($moduleId, $examId)
    {
        $exam = Exam::Status()->where('module_id', $moduleId)->with(['questions' => function($q){
            return $q->with('options','mediaFirst');
        }])->findOrFail($examId);

        return response()->json([
            'data' => new ExamResource($exam)
        ]);
    }

    public function submitMcqExam(SubmitMcqExamRequest $request,Exam $exam)
    {
        $selectedAnswers = $request->answers;
        $questions = Question::whereIn('id', array_keys($selectedAnswers))->with('options')->get();

        $totalScore = 0;

        foreach ($questions as $question) {
            $selectedOptionIds = $selectedAnswers[$question->id];
            $selectedOptionIds = array_map('intval', $selectedOptionIds);
            $correctOptionIds = $question->options->where('is_correct', 1)->pluck('id')->toArray();

            if (empty(array_diff($selectedOptionIds, $correctOptionIds)) && !empty($selectedOptionIds)) {
                $totalScore += $question->point;
            }

        }
        $examResult =  ExamResult::create([
            'user_id' => Auth::user()->id,
            'exam_id' => $exam->id,
            'total_score' => $totalScore
        ]);

        return response()->json([
            'message' => "Response is Submitted , Thank You",
            'data' => new ExamResultResource($examResult)
        ],Response::HTTP_CREATED);

    }

    public function submitFlashExam(SubmitFlashExamRequest $request, Exam $exam)
    {
        $selectedAnswers = $request->answers;
        $questions = Question::whereIn('id', array_keys($selectedAnswers))->with('options')->get();

        $totalScore = 0;

        foreach ($questions as $question) {
            $answerOptionFlash = $selectedAnswers[$question->id];
            foreach ($question->options as $option) {
                $modelOption = (int) json_decode($option->option);
                if($answerOptionFlash == $modelOption){
                    $totalScore += $question->point;
                    break;
                }
            }
        }

        $examResult =  ExamResult::create([
            'user_id' => Auth::user()->id,
            'exam_id' => $exam->id,
            'total_score' => $totalScore
        ]);

        return response()->json([
            'message' => "Response is Submitted , Thank You",
            'data' => new ExamResultResource($examResult)
        ],Response::HTTP_CREATED);
    }

    public function submitTableExam(SubmitTableExamRequest $request, Exam $exam)
    {
        $selectedAnswers = $request->answers;
        $questions = Question::whereIn('id', array_keys($selectedAnswers))->with('options')->get();

        $totalScore = 0;


        foreach ($questions as $question) {
            $answertableOption = $selectedAnswers[$question->id];
            foreach ($question->options as $option) {
                $modelOption = json_decode($option->option);
                $matching = array_intersect_assoc($modelOption, $answertableOption);
                $answerPerMatch = $question->point / count($modelOption);
                $totalScore += (count($matching) * $answerPerMatch);
            }
        }

        $examResult =  ExamResult::create([
            'user_id' => Auth::user()->id,
            'exam_id' => $exam->id,
            'total_score' => $totalScore
        ]);

        return response()->json([
            'message' => "Response is Submitted , Thank You",
            'data' => new ExamResultResource($examResult)
        ],Response::HTTP_CREATED);

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

    public function getAllExamResult()
    {
        $results = ExamResult::where('user_id',Auth::user()->id)->with('exam')->get();
        return response()->json([
            'results' => ExamResultResource::collection($results),
        ]);
    }

}
