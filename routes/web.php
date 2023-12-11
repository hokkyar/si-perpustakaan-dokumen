<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  return view('welcome');
});

Route::get('/login', [AuthController::class, 'index'])->name('page.login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.authenticate');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => 'checkLogin'], function () {
  Route::resource('upload', UploadController::class);
  Route::resource('dashboard', DashboardController::class);
  Route::get('/dashboard/download/{drive_id}', [DashboardController::class, 'download'])->name('dashboard.download');
  Route::get('/settings', [SettingController::class, 'index'])->name('page.setting');
  Route::put('/settings/profile', [SettingController::class, 'changeProfile'])->name('page.setting.profile');
  Route::put('/settings/token', [SettingController::class, 'updateToken'])->name('page.setting.token');
  Route::put('/settings/password', [SettingController::class, 'changePassword'])->name('page.setting.password');
  Route::get('/gdrive-setup', [SettingController::class, 'setupPage'])->name('setupPage');
  Route::put('/gdrive-setup', [SettingController::class, 'changeDrive'])->name('changeDrive');
});
