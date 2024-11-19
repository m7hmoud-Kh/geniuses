<?php

namespace App\Http\Middleware;

use App\Models\Exam;
use App\Models\Question;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CombineTypeOfExamInStoreQuestion
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->exam_id){
            $exam = Exam::findOrFail($request->exam_id);
        }else {
            $question = Question::with('exam')->whereId($request->questionId)->first();
            $exam = $question->exam;
        }
        $request->merge(['type' => $exam->type]);
        return $next($request);
    }
}
