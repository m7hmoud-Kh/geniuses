<?php

use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\Website\AssignmentController;
use App\Http\Controllers\Website\AuthController;
use App\Http\Controllers\Website\CategoryController;
use App\Http\Controllers\Website\ExamController;
use App\Http\Controllers\Website\FeedBackController;
use App\Http\Controllers\Website\LessonController;
use App\Http\Controllers\Website\ModuleController;
use App\Http\Controllers\Website\PollController;
use App\Http\Controllers\Website\ProfileController;
use App\Http\Controllers\Website\SubscriptionController;
use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)->group(function(){
    Route::post('/register','register');
    Route::post('/login','login');
    Route::get('/verify/{token}','verifyAccount');
    Route::middleware('auth:api')->group(function(){
        Route::post('/logout','logout');
        Route::get('/user-profile','userProfile');
        Route::post('/update','update');
        Route::post('/change-password','changePassword');
    });
});
Route::post('/forget-password',[PasswordResetController::class,'sendEmailLink']);
Route::post('/reset-password',[PasswordResetController::class,'resetPassword']);

Route::controller(CategoryController::class)->prefix('/categories')->group(function(){
    Route::get('/','getAllActiveCategories');
    Route::get('/{categoryId}','showCategoryById')->middleware('check.token.valid');
});


Route::middleware('auth:api')->group(function(){

    Route::controller(SubscriptionController::class)->group(function(){
        Route::post('/create-payment-intent','createPaymentIntent');
    });

    Route::controller(ProfileController::class)->prefix('profile')->group(function(){
        Route::get('/modules-subscripted','showActiveModulesSubscripted');
        Route::get('/categories-subscripted','showActiveCategoriesSubscripted');
        Route::get('/assignments','getAllAssignments');
        Route::get('/exam-results','getAllExamResult');
    });

    Route::middleware('check.subscription')
    ->prefix('/{category_id}/modules/{module_id}')
    ->group(function(){
        Route::controller(ModuleController::class)
        ->group(function(){
            Route::get('/','show');
        });

        Route::controller(AssignmentController::class)
        ->prefix('/attachments')
        ->group(function(){
            Route::post('/','store');
            Route::get('/','index');
            Route::delete('/{assignment_id}','destory');
        });

        Route::controller(ExamController::class)
        ->prefix('exams')
        ->group(function(){
            Route::get('/{exam_id}','show');
            Route::post('/{exam_id}', 'submitExam');
        });

        Route::controller(LessonController::class)->prefix('lessons')->group(function(){
            Route::get('/{lesson_id}','show');
        });

        Route::controller(PollController::class)
        ->prefix('polls')
        ->group(function(){
            Route::get('/','index');
        });

        Route::controller(FeedBackController::class)
        ->prefix('feedback')
        ->group(function(){
            Route::post('/','store');
        });
    });
});

Route::controller(SettingController::class)->prefix('/settings')->group(function(){
    Route::get('/','index');
});





