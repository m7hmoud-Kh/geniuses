<?php

use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\ExamController;
use App\Http\Controllers\Dashboard\FqaController;
use App\Http\Controllers\Dashboard\ModuleController;
use App\Http\Controllers\Dashboard\QuestionController;
use App\Http\Controllers\PasswordResetController;
use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)->group(function(){
    Route::post('/login','login');
    Route::middleware('auth:admin')->group(function(){
        Route::post('/logout','logout');
        Route::get('/user-profile','userProfile');
        Route::post('/update','update');
        Route::post('/change-password','changePassword');
    });
});
Route::post('/forget-password',[PasswordResetController::class,'sendEmailLink']);
Route::post('/reset-password',[PasswordResetController::class,'resetPassword']);

Route::middleware('auth:admin')->group(function(){
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('modules', ModuleController::class);
    Route::apiResource('fqas', FqaController::class);
    Route::apiResource('exams', ExamController::class);
    Route::apiResource('questions', QuestionController::class)
    ->only(['store', 'update'])
    ->middleware('combine_exam_type');
    Route::apiResource('questions', QuestionController::class)
    ->except(['store', 'update']);
    Route::delete('/modules/{attachmentId}/attachment',[ModuleController::class,'destoryAttachmentById']);
});
