<?php

use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\Website\AuthController;
use App\Http\Controllers\Website\CategoryController;
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
    Route::get('/{categoryId}','showCategoryById');
});
