<?php

use App\Http\Controllers\Dashboard\AssignmentController;
use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\ExamController;
use App\Http\Controllers\Dashboard\FqaController;
use App\Http\Controllers\Dashboard\InfluencerController;
use App\Http\Controllers\Dashboard\InstructorController;
use App\Http\Controllers\Dashboard\InvoiceController;
use App\Http\Controllers\Dashboard\LessonController;
use App\Http\Controllers\Dashboard\ModuleController;
use App\Http\Controllers\Dashboard\OptionController;
use App\Http\Controllers\Dashboard\PollController;
use App\Http\Controllers\Dashboard\QuestionController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\StatisticController;
use App\Http\Controllers\Dashboard\SubscriptionController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Resources\InvoiceResource;
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
    Route::get('/categories-selections', [CategoryController::class,'getAllCategoriesInSelections']);
    Route::apiResource('modules', ModuleController::class);
    Route::get('/modules-selections',[ModuleController::class,'getAllModulesInSelections']);
    Route::apiResource('fqas', FqaController::class);
    Route::apiResource('exams', ExamController::class);
    Route::apiResource('instructors', InstructorController::class);
    Route::apiResource('lessons', LessonController::class);
    Route::apiResource('polls', PollController::class);
    Route::apiResource('influencers', InfluencerController::class);
    Route::apiResource('invoices', InvoiceController::class, [
        'only' => ['index', 'store','destroy']
    ]);
    Route::controller(QuestionController::class)->prefix('/questions')->group(function(){
        Route::middleware('combine_exam_type_in_question')->group(function(){
            Route::put('/{questionId}','update');
            Route::post('/','store');
        });
        Route::get('/','index');
        Route::get('/{question}','show');
        Route::delete('/{question}','destroy');
    });

    Route::controller(OptionController::class)->prefix('/options')->group(function(){
        Route::middleware('combine_exam_type_in_option')->group(function(){
            Route::put('/{optionId}','update');
            Route::post('/','store');
        });
        Route::get('/','index');
        Route::get('/{option}','show');
        Route::delete('/{option}','destroy');
    });

    Route::delete('/modules/{attachmentId}/attachment',[ModuleController::class,'destroyAttachmentById']);

    Route::get('/modules/assignments/{module_id}',[AssignmentController::class,'index']);

    Route::get('/users', [UserController::class,'index']);
    Route::get('/users-selections', [UserController::class, 'getAllUsersInSelections']);

    Route::controller(StatisticController::class)->group(function(){
        Route::get('/get-current-eraning-monthly','getCurrentEarningMonth');
        Route::get('/get-current-eraning-yearly','getYearlyEarning');
    });

    Route::controller(SubscriptionController::class)->group(function(){
        Route::post('/subscriptions','store');
    });

    Route::controller(SettingController::class)->prefix('/settings')->group(function(){
        Route::get('/','index');
        Route::get('/{id}','show');
        Route::post('/{id}','update');
    });
});
