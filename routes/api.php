<?php

use App\Http\Controllers\api\{AuthController,PasswordResetController};
use App\Http\Controllers\api\teacher\{TeacherGroupsController};
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/password/send-code', [PasswordResetController::class, 'sendCode']);
Route::post('/password/verify-code', [PasswordResetController::class, 'verifyCode']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']); 
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/update-password', [AuthController::class, 'updatePassword']);
    // O'QITUVCHI 
    Route::get('/teacher/home', [TeacherGroupsController::class, 'home']); 
    Route::get('/teacher/home/show/{id}', [TeacherGroupsController::class, 'homeShow']); 
    Route::get('/teacher/home/show/user/{id}', [TeacherGroupsController::class, 'homeShowUsers']); 
    Route::get('/teacher/home/show/data/{id}', [TeacherGroupsController::class, 'HomeShowData']); 
});