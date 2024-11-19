<?php

namespace App\Http\Middleware;

use App\Models\Option;
use App\Models\Question;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CombineTypeOfExamInStoreOption
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->question_id){
            $question = Question::with('exam')->findOrFail($request->question_id);
            $exam = $question->exam;
        }else {
            $option = Option::with(['question' => function($q){
                return $q->with('exam');
            }])->findOrFail($request->optionId);
            $exam = $option->question->exam;
        }
        $request->merge(['type' => $exam->type]);
        return $next($request);
    }
}
