<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PiutangPaymentController;
use App\Http\Controllers\User\AnggotaController;
use App\Http\Controllers\AuthController;
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




Route::get('/login', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth', 'verified');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth', 'verified');

Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    });
});

Route::middleware(['auth', 'verified', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [AnggotaController::class, 'dashboard'])->name('dashboard');
    // Route::get('/user/dashboard', function () {
    //     return view('user.dashboard');
    // });
});
