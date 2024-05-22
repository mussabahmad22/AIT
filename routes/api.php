<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



//=================================Login Route =============================================
Route::post('/login',  [ApiController::class, 'login']);

//===============================current_cd_details Routes==================================
Route::get('current_cd_details', [ApiController::class, 'current_cd_details']);

//===========================Notification Against User Routes==================================
Route::get('notification', [ApiController::class, 'notification'])->name('notification'); 

//===========================History Against User Routes==================================
Route::get('history', [ApiController::class, 'history'])->name('history'); 

//===========================Time Listened Against User Routes==================================
Route::get('time_listened', [ApiController::class, 'time_listened'])->name('time_listened'); 

//=============================== chk User api ========================
Route::get('chk_user', [ApiController::class, 'chk_user'])->name('chk_user');

//=============================== player_time api ========================
Route::get('player_time', [ApiController::class, 'player_time'])->name('player_time');

//=============================== percentage api ==========================
Route::get('percentage', [ApiController::class, 'percentage'])->name('percentage');

//=============================== breakout api ==========================
Route::post('breakout', [ApiController::class, 'breakout'])->name('breakout');

//=============================== breakdown api ==========================
Route::get('breakdown', [ApiController::class, 'breakdown'])->name('breakdown');

//=============================== Contact api ==========================
Route::get('contact', [ApiController::class, 'contact'])->name('contact');

//=============================== silent_noti api ==========================
Route::get('silent_noti', [ApiController::class, 'silent_noti'])->name('silent_noti');

//=============================== Chk token api ==========================
Route::get('token', [ApiController::class, 'token'])->name('token');

//=============================== Change status of device change api ==========================
Route::get('device_change_status', [ApiController::class, 'device_change_status'])->name('device_change_status');

//=============================== breakdown api ==========================
Route::get('breakdown_all_user', [ApiController::class, 'breakdown_all_user'])->name('breakdown_all_user');

//=============================== replace_device_id api ==========================
Route::get('replace_device_id', [ApiController::class, 'replace_device_id'])->name('replace_device_id');