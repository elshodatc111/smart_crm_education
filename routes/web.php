<?php

use App\Http\Controllers\web\{
    AuthController,
    BalansController,
    EmploesController,
    HomeController,
    KassaController,
    SettingController,
    TashrifController,
    DamOlishController,
    GroupController,
};
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/error/403', [AuthController::class, 'error_403'])->name('error_403');
Route::get('/error/404', [AuthController::class, 'error_404'])->name('error_404');
Route::post('/login/post', [AuthController::class, 'login_post'])->name('login_post');

Route::middleware(['auth','role:admin,director,manager,operator'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/', [HomeController::class, 'dashboard'])->name('home');
    # TASHRIF
    Route::get('/visits', [TashrifController::class, 'tashriflar'])->name('tashriflar');
    Route::post('/visits/store', [TashrifController::class,'store'])->name('visits_store');
    Route::get('/visits/show/{id}', [TashrifController::class, 'tashrifShow'])->name('tashrif_show');
    Route::post('/visits/notes/store', [TashrifController::class, 'storeNote'])->name('notes_store');
    Route::post('/visits/users/status', [TashrifController::class, 'changeStatus'])->name('users_status');
    Route::post('/visits/reset-password', [TashrifController::class, 'resetPassword'])->name('users_reset_password');
    Route::put('/visits/update/{id}', [TashrifController::class, 'update'])->name('users_update');
    Route::post('/group/add/user', [TashrifController::class, 'addGroup'])->name('add_user_group');
    # KASSA
    Route::get('/kassa', [KassaController::class, 'kassa'])->name('kassa');
    Route::post('/kassa/chiqim', [KassaController::class, 'chiqim'])->name('kassa_chiqim');
    Route::post('/kassa-history/{id}/cancel', [KassaController::class, 'cancel'])->name('kassa_history_cancel');
    # Guruhlar
    Route::get('/groups', [GroupController::class, 'groups'])->name('groups');
    Route::get('/group/show/{id}', [GroupController::class, 'show'])->name('group_show');
    Route::post('/group/store', [GroupController::class, 'store'])->name('group_store');
});
# Hodimlar
Route::middleware(['auth','role:admin,director'])->group(function () { 
    # Kassa success    
    Route::post('/kassa-history/{id}/approve', [KassaController::class, 'approve'])->name('kassa_history_approve');
    # Balans
    Route::get('/balans', [BalansController::class, 'balans'])->name('balans');
    Route::post('/balans/chiqim', [BalansController::class, 'balansChiqim'])->name('balans_chiqim');
    Route::post('/balans/convert', [BalansController::class, 'balansConvert'])->name('balans_convert');
    Route::post('/balans/exson', [BalansController::class, 'exsonChiqim'])->name('balans_exson');
    # Hodimlar
    Route::get('/emploes', [EmploesController::class, 'emploes'])->name('emploes');
    Route::get('/emploes/show/{id}', [EmploesController::class, 'emploesShow'])->name('emploes_show');
    Route::post('/emploes/store', [EmploesController::class, 'store'])->name('emploes_store');
});
# Sozlamalar
Route::middleware(['auth','role:admin,director'])->group(function () {
    Route::get('/setting/payment', [SettingController::class, 'payment'])->name('setting_payment');
    Route::post('/setting/payment-settings/store', [SettingController::class, 'storePayment'])->name('payment_settings_store');
    Route::delete('/setting/payment-settings/{id}', [SettingController::class, 'destroyPayment'])->name('payment_setting_delete');
    Route::get('/setting/cours/room', [SettingController::class, 'coursRoom'])->name('setting_cours');
    Route::get('/setting/cours/show/{id}', [SettingController::class, 'coursShow'])->name('setting_cours_show');
    Route::post('/setting/cours/store', [SettingController::class,'storeCours'])->name('cours_store');
    Route::delete('/setting/cours/destroy/{id}', [SettingController::class,'destroyCours'])->name('cours_destroy');
    Route::put('/setting/cours/{id}', [SettingController::class, 'updateCours'])->name('cours_update');
    Route::post('/setting/videos/store', [SettingController::class, 'storeVideo'])->name('videos_store');
    Route::delete('/setting/video/destroy/{id}', [SettingController::class,'destroyVideo'])->name('video_destroy');
    Route::post('/setting/tests/store', [SettingController::class, 'storeTest'])->name('tests_store');
    Route::delete('/setting/test/destroy/{id}', [SettingController::class,'destroyTest'])->name('test_destroy');
    Route::post('/setting/audio/store', [SettingController::class, 'storeAudio'])->name('audio_store');
    Route::delete('/setting/audio/{id}', [SettingController::class, 'destroyAudio'])->name('audio_delete');
    Route::post('/setting/books/store', [SettingController::class, 'storeBook'])->name('books_store');
    Route::delete('/setting/books/{id}', [SettingController::class, 'destroyBook'])->name('book_delete');
    Route::get('/setting/region', [SettingController::class, 'region'])->name('setting_region');
    Route::post('/setting/region/create', [SettingController::class, 'createRegion'])->name('setting_region_create');
    Route::delete('/setting/regions/{id}', [SettingController::class, 'destroyRegion'])->name('regions_destroy');
    Route::post('/setting/sms/update', [SettingController::class, 'smsUpdate'])->name('sms_settings_update');
    Route::delete('/setting/classroom/{classroom}', [SettingController::class, 'destroyRoom'])->name('classroom_destroy');
    Route::post('/setting/classrooms/store',[SettingController::class,'storeRoom'])->name('classrooms_store');
    Route::post('/setting/kassa-settings', [SettingController::class, 'updateSettingUpdate'])->name('kassa_settings_update');
    Route::get('/setting/damolish', [DamOlishController::class, 'damOlish'])->name('setting_dam_olish');
    Route::post('/setting/damolish/create', [DamOlishController::class, 'store'])->name('setting_dam_olish_store');
});
