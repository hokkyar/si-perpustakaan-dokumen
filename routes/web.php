<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
  return view('welcome');
});

Route::resource('upload', UploadController::class)->middleware('checkLogin');
Route::resource('dashboard', DashboardController::class)->middleware('checkLogin');
Route::get('/dashboard/download/{drive_id}', [DashboardController::class, 'download'])->name('dashboard.download')->middleware('checkLogin');

Route::get('/login', [AuthController::class, 'index'])->name('page.login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.authenticate');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
