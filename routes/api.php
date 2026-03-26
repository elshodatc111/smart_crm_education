<?php

use App\Http\Controllers\api\{AuthController,PasswordResetController};
use App\Http\Controllers\api\teacher\{TeacherGroupsController, TeacherPaymentController};
use App\Http\Controllers\api\user\UserGroupController;
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
    Route::post('/teacher/home/attendance', [TeacherGroupsController::class, 'davomad']); 
    Route::get('/teacher/home/attendance/history/{id}', [TeacherGroupsController::class, 'attendanceHistory']); 
    Route::get('/teacher/home/test/natija/{id}', [TeacherGroupsController::class, 'testNatija']); 
    Route::get('/teacher/ishhaqi', [TeacherPaymentController::class, 'payments']); 
    // Users
    Route::get('/user/home', [UserGroupController::class, 'home']); 
    Route::get('/user/home/video/{id}', [UserGroupController::class, 'video']); 
    Route::get('/user/home/audio/{id}', [UserGroupController::class, 'audio']); 
    Route::get('/user/home/book/{id}', [UserGroupController::class, 'book']); 
    Route::get('/user/groups', [UserGroupController::class, 'allGroups']);
    Route::get('/user/group/show/{id}', [UserGroupController::class, 'groupsShow']);
    Route::get('/user/payment', [UserGroupController::class, 'payments']);

});