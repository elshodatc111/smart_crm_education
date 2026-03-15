<?php

use App\Http\Controllers\web\AuthController;
use App\Http\Controllers\web\HomeController;
use App\Http\Controllers\web\SettingController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/error/403', [AuthController::class, 'error_403'])->name('error_403');
Route::get('/error/404', [AuthController::class, 'error_404'])->name('error_404');
Route::post('/login/post', [AuthController::class, 'login_post'])->name('login_post');

Route::middleware(['auth','role:admin,director,manager,operator,user'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/', [HomeController::class, 'dashboard'])->name('home');
    Route::get('/admin', function () {return "Admin panel";});

});
Route::middleware(['auth','role:admin,director'])->group(function () {
    Route::get('/setting/room', [SettingController::class, 'room'])->name('setting_room');
    Route::get('/setting/payment', [SettingController::class, 'payment'])->name('setting_payment');
    Route::get('/setting/cours', [SettingController::class, 'cours'])->name('setting_cours');
    Route::get('/setting/region', [SettingController::class, 'region'])->name('setting_region');
    Route::post('/setting/region/create', [SettingController::class, 'createRegion'])->name('setting_region_create');
    Route::delete('/setting/regions/{id}', [SettingController::class, 'destroyRegion'])->name('regions_destroy');
    Route::post('/setting/sms/update', [SettingController::class, 'smsUpdate'])->name('sms_settings_update');

});
