<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class checkTokenValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        try {
            if (!$request->header('Authorization')) {
                return $next($request);
            }

            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return response()->json([
                    'message' => 'Token is not valid'
                ], Response::HTTP_UNAUTHORIZED);
            }
            return $next($request);

        } catch (TokenExpiredException $e) {
            return response()->json([
                'message' => 'Token is not valid'
            ], Response::HTTP_UNAUTHORIZED);
        } catch (TokenInvalidException $e) {
            return response()->json([
                'message' => 'Token is not valid'
            ], Response::HTTP_UNAUTHORIZED);
        }

    }
}
