<?php

namespace App\Http\Middleware;

use App\Models\Feedback;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckIfSendFeedbackToModule
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Feedback::where('module_id',$request->module_id)->where('user_id',Auth::user()->id)->exists()){
            return response()->json([
                'message' => 'Your Send Feeback about this module before, can\'t send again'
            ], Response::HTTP_BAD_REQUEST);
        }
        return $next($request);
    }
}
