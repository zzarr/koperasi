<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PiutangPaymentController;
use App\Http\Controllers\User\AnggotaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ManageMetaDataController;

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

//andin
Route::get('admin/metadata/datatables', [ManageMetaDataController::class, 'datatable'])->name('metadatadatatables.data');
Route::get('/admin/metadata', [ManageMetaDataController::class, 'index'])->name('manage_metadata');
Route::post('/admin/metadata', [ManageMetaDataController::class, 'store'])->name('manage_metadata.store');
Route::put('/admin/metadata/update/{id}', [ManageMetaDataController::class, 'update'])->name('manage_metadata.update');

Route::middleware(['auth', 'verified', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [AnggotaController::class, 'dashboard'])->name('dashboard');
    // Route::get('/user/dashboard', function () {
    //     return view('user.dashboard');
    // });
});
