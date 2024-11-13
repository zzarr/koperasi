<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PiutangPaymentController;

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

Route::get('/dashboard', function () {
    return view('admin.dashboard');
});

Route::get('/payment/piutang', [PiutangPaymentController::class, 'index'])->name('payment_piutang');



Route::get('/dashboard/user', function () {
    return view('user.dashboard');
});