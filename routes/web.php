<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    PiutangPaymentController,
    MainPaymentController,
    MonthlyPaymentController,
    WithdrawController,
};
use App\Http\Controllers\User\AnggotaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ManageMetaDataController;
use App\Http\Controllers\Admin\DashboardController;

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
    Route::group(['as' => 'admin.'], function () {

        Route::group(['prefix' => 'payment', 'as' => 'payment.'], function () {
            Route::group(['prefix' => 'main', 'as' => 'main.'], function () {
                Route::get('/', [MainPaymentController::class, 'index'])->name('index');
                Route::get('/datatables', [MainPaymentController::class, 'datatables'])->name('ajax');
                Route::get('/show/{id?}', [MainPaymentController::class, 'show'])->name('show');
                Route::post('/store', [MainPaymentController::class, 'store'])->name('store');
                Route::post('/destroy/{id?}', [MainPaymentController::class, 'destroy'])->name('destroy');

                Route::post('/import', [MainPaymentController::class, 'import'])->name('import');
            });

            Route::group(['prefix' => 'monthly', 'as' => 'monthly.'], function () {
                Route::get('/', [MonthlyPaymentController::class, 'index'])->name('index');
                Route::get('/datatables', [MonthlyPaymentController::class, 'datatables'])->name('ajax');
                Route::get('/show/{id?}', [MonthlyPaymentController::class, 'show'])->name('show');
                Route::post('/store', [MonthlyPaymentController::class, 'store'])->name('store');
                Route::post('/destroy/{id?}', [MonthlyPaymentController::class, 'destroy'])->name('destroy');

                Route::post('/import', [MonthlyPaymentController::class, 'import'])->name('import');
            });
        });
        
        Route::group(['prefix' => 'withdraw', 'as' => 'withdraw.'], function () {
            Route::get('/', [WithdrawController::class, 'index'])->name('index');
            Route::get('/datatables', [WithdrawController::class, 'datatables'])->name('ajax');
            Route::get('/show/{id?}', [WithdrawController::class, 'show'])->name('show');
            Route::post('/store', [WithdrawController::class, 'store'])->name('store');
            Route::delete('/destroy/{id?}', [WithdrawController::class, 'destroy'])->name('destroy');
        });

        //andin
        Route::group(['prefix' => 'metadata', 'as' => 'metadata.'], function () {
            Route::get('datatables', [ManageMetaDataController::class, 'datatable'])->name('metadatadatatables.data');
            Route::get('/', [ManageMetaDataController::class, 'index'])->name('manage_metadata');
            Route::post('/store', [ManageMetaDataController::class, 'store'])->name('manage_metadata.store');
            Route::put('update/{id}', [ManageMetaDataController::class, 'update'])->name('manage_metadata.update');
        });

    //andin
    Route::group(['prefix' => 'metadata', 'as' => 'metadata.'], function () {
        Route::get('datatables', [ManageMetaDataController::class, 'datatable'])->name('metadatadatatables.data');
        Route::get('/', [ManageMetaDataController::class, 'index'])->name('manage_metadata');
        Route::post('/', [ManageMetaDataController::class, 'store'])->name('manage_metadata.store');
        Route::put('update/{id}', [ManageMetaDataController::class, 'update'])->name('manage_metadata.update');
    });
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});





Route::middleware(['auth', 'verified', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [AnggotaController::class, 'dashboard'])->name('dashboard');
    // Route::get('/user/dashboard', function () {
    //     return view('user.dashboard');
    // });
});
