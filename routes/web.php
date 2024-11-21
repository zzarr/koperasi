<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    PiutangController,
    PembayaranPiutangController,
    MainPaymentController,
    MonthlyPaymentController,
    WithdrawController,
    DashboardController,
    OtherPaymentController,
    MasterDataController
};
use App\Http\Controllers\user\{
    AnggotaController,
    PaymentHistoryController,
    // MasterDataController
};
use App\Http\Controllers\AuthController;
use App\Models\PembayaranPiutang;

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware(['auth', 'verified']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware(['auth', 'verified']);

// Admin Routes
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
        // Payment Routes
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

            Route::group(['prefix' => 'other', 'as' => 'other.'], function () {
                Route::get('/', [OtherPaymentController::class, 'index'])->name('index');
                Route::get('/datatables', [OtherPaymentController::class, 'datatables'])->name('ajax');
                Route::get('/show/{id?}', [OtherPaymentController::class, 'show'])->name('show');
                Route::post('/store', [OtherPaymentController::class, 'store'])->name('store');
                Route::post('/destroy/{id?}', [OtherPaymentController::class, 'destroy'])->name('destroy');
                Route::post('/import', [OtherPaymentController::class, 'import'])->name('import');
            });
        });

        // piutang
        Route::group(['prefix' => 'piutang', 'as' => 'piutang.'], function () {
                    Route::get('/', [PiutangController::class, 'index'])->name('index');
                    Route::get('/datatables', [PiutangController::class, 'datatables'])->name('ajax');
                    Route::post('/store', [PiutangController::class, 'store'])->name('store');
                    Route::get('/users', [PiutangController::class, 'getUsers'])->name('users.get'); 
                    Route::delete('/delete/{id?}', [PiutangController::class, 'destroy'])->name('delete');
                    Route::group(['prefix' => 'pembayaran', 'as' => 'pembayaran.'], function () {
                        Route::get('/{id}', [PembayaranPiutangController::class, 'getPiutang'])->name('get');
                        Route::group(['prefix' => 'rutin', 'as' => 'rutin.'], function () {
                            Route::get('/datatables', [PembayaranPiutangController::class, 'datatables'])->name('ajax');
                            Route::get('/{id}/detail', [PembayaranPiutangController::class, 'showRutinDetail'])->name('detail');
                        });
                        Route::group(['prefix' => 'khusus', 'as' => 'khusus.'], function () {
                            Route::post('/store', [PembayaranPiutangController::class, 'storeKhusus'])->name('store');
                            Route::get('/datatables', [PembayaranPiutangController::class, 'datatables'])->name('ajax');
                            Route::get('/{id}/detail', [PembayaranPiutangController::class, 'showKhususDetail'])->name('detail');
                        });
                    });
        });

        // Withdraw Routes
        Route::group(['prefix' => 'withdraw', 'as' => 'withdraw.'], function () {
            Route::get('/', [WithdrawController::class, 'index'])->name('index');
            Route::get('/datatables', [WithdrawController::class, 'datatables'])->name('ajax');
            Route::get('/show/{id?}', [WithdrawController::class, 'show'])->name('show');
            Route::post('/store', [WithdrawController::class, 'store'])->name('store');
            Route::delete('/destroy/{id?}', [WithdrawController::class, 'destroy'])->name('destroy');

            Route::get('/user-wallet/{id?}', [WithdrawController::class, 'userWallet'])->name('info');
        });

        // Metadata Routes
        Route::group(['prefix' => 'metadata', 'as' => 'metadata.'], function () {
            Route::get('/datatables', [MasterDataController::class, 'datatable'])->name('metadatadatatables.data');
            Route::get('/', [MasterDataController::class, 'index'])->name('manage_metadata');
            Route::post('/store', [MasterDataController::class, 'store'])->name('manage_metadata.store');
            Route::put('/update/{id}', [MasterDataController::class, 'update'])->name('manage_metadata.update');


            Route::get('/get-data', [MasterDataController::class, 'getData'])->name('get.data');
        });

        // Dashboard Route
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });
});

// User Routes
Route::middleware(['auth', 'verified', 'role:user'])->group(function () {

    Route::get('/user/dashboard', [AnggotaController::class, 'dashboard'])->name('user.dashboard');
    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {


        //route history pembayaran
        Route::group(['prefix' => 'history', 'as' => 'history.'], function () {
            Route::get('/main', [PaymentHistoryController::class, 'main'])->name('main');
            Route::get('/main/ajax', [PaymentHistoryController::class, 'mainDatatable'])->name('main.ajax');
            Route::get('/mothly', [PaymentHistoryController::class, 'mothly'])->name('mothly');
            Route::get('/mothly/ajax', [PaymentHistoryController::class, 'mothlyDatatable'])->name('mothly.ajax');
            Route::get('/other', [PaymentHistoryController::class, 'other'])->name('other');
            Route::get('/other/ajax', [PaymentHistoryController::class, 'otherDatatable'])->name('other.ajax');
        });
        //end route history pembayaran


    });
});
