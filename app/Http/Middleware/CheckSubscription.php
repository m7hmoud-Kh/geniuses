<?php

namespace App\Http\Middleware;

use App\Models\Category;
use App\Models\Module;
use App\Models\Subscription;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $categoryId = $request->route('category_id');
        $moduleId = $request->route('module_id');

        $category = Category::with('modules')->find($categoryId);
        if (!$category || !$category->modules->contains('id', $moduleId)) {
            return response()->json(['error' => 'Category does not have this module.'], Response::HTTP_BAD_REQUEST);
        }
        $subscription = Subscription::where('user_id', $user->id)
        ->where('category_id', $categoryId)
        ->OrWhere('module_id', $moduleId)
        ->where('start_date', '<=', now())
        ->where('end_date', '>=', now())
        ->exists();

        if (!$subscription) {
            return response()->json(['message' => 'Access Denied'], 403);
        }

        return $next($request);

    }
}
