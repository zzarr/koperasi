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
    MasterDataController,
    UserController
};
use App\Http\Controllers\user\{
    AnggotaController,
    PaymentHistoryController,
    HistoryPiutangController
    // MasterDataController
};
use App\Http\Controllers\AuthController;
use App\Models\PembayaranPiutang;

Route::get('/', function () {
    return redirect()->route('login');
});


// Authentication Routes
Route::get('/login', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware(['auth', 'verified']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware(['auth', 'verified']);

// Admin Routes
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {

    
    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::group(['prefix' => 'report', 'as' => 'report.'], function () {
            Route::get('/', [MonthlyPaymentController::class, 'indexReport'])->name('index');
            Route::post('/exportInvoice', [MonthlyPaymentController::class, 'exportInvoiceReport'])->name('export');
        });
        
        // Payment Routes
        Route::group(['prefix' => 'payment', 'as' => 'payment.'], function () {
            Route::group(['prefix' => 'main', 'as' => 'main.'], function () {
                Route::get('/', [MainPaymentController::class, 'index'])->name('index');
                Route::get('/datatables', [MainPaymentController::class, 'datatables'])->name('ajax');
                Route::get('/show/{id?}', [MainPaymentController::class, 'show'])->name('show');
                Route::post('/store', [MainPaymentController::class, 'store'])->name('store');
                Route::post('/destroy/{id?}', [MainPaymentController::class, 'destroy'])->name('destroy');
                Route::post('/import', [MainPaymentController::class, 'import'])->name('import');

                Route::get('/data_tanggal/{id}', [MainPaymentController::class, 'dataTanggal'])->name('dataTanggal');
                Route::post('/exportInvoice', [MainPaymentController::class, 'exportInvoice'])->name('export');
            });

            Route::group(['prefix' => 'monthly', 'as' => 'monthly.'], function () {
                Route::get('/', [MonthlyPaymentController::class, 'index'])->name('index');
                Route::get('/datatables', [MonthlyPaymentController::class, 'datatables'])->name('ajax');
                Route::get('/show/{id?}', [MonthlyPaymentController::class, 'show'])->name('show');
                Route::post('/store', [MonthlyPaymentController::class, 'store'])->name('store');
                Route::delete('/destroy/{id?}', [MonthlyPaymentController::class, 'destroy'])->name('destroy');
                Route::post('/import', [MonthlyPaymentController::class, 'import'])->name('import');
                Route::get('/download/{id}', [MonthlyPaymentController::class, 'downloadInvoice'])->name('download');

                Route::get('/data_tanggal/{id}', [MonthlyPaymentController::class, 'dataTanggal']);
                Route::post('/exportInvoice', [MonthlyPaymentController::class, 'exportInvoice'])->name('export');

                // Route::get('/invoice/preview/{id}', [MonthlyPaymentController::class, 'previewInvoice'])->name('invoice');
            });

            Route::group(['prefix' => 'other', 'as' => 'other.'], function () {
                Route::get('/', [OtherPaymentController::class, 'index'])->name('index');
                Route::get('/datatables', [OtherPaymentController::class, 'datatables'])->name('ajax');
                Route::get('/show/{id?}', [OtherPaymentController::class, 'show'])->name('show');
                Route::post('/store', [OtherPaymentController::class, 'store'])->name('store');
                Route::delete('/destroy/{id?}', [OtherPaymentController::class, 'destroy'])->name('destroy');
                Route::post('/import', [OtherPaymentController::class, 'import'])->name('import');

                Route::get('/data_tanggal/{id}', [OtherPaymentController::class, 'dataTanggal'])->name('dataTanggal');
                Route::post('/exportInvoice', [OtherPaymentController::class, 'exportInvoice'])->name('export');
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
                    Route::post('/store', [PembayaranPiutangController::class, 'storeRutin'])->name('store');
                    Route::get('/datatables', [PembayaranPiutangController::class, 'datatablesRutin'])->name('ajax');
                    Route::get('/{id}/detail', [PembayaranPiutangController::class, 'showRutinDetail'])->name('detail');
                    Route::get('/print/{paymentId}', [PembayaranPiutangController::class, 'printPaymentRutin'])->name('printPayment');
                    Route::get('/print-all/{hutang_id}', [PembayaranPiutangController::class, 'printAllRutin'])->name('admin.piutang.pembayaran.rutin.printAll');

                });
                Route::group(['prefix' => 'khusus', 'as' => 'khusus.'], function () {
                    Route::post('/store', [PembayaranPiutangController::class, 'storeKhusus'])->name('store');
                    Route::get('/datatables', [PembayaranPiutangController::class, 'datatablesKhusus'])->name('ajax');
                    Route::get('/{id}/detail', [PembayaranPiutangController::class, 'showKhususDetail'])->name('detail');
                    Route::get('/print/{paymentId}', [PembayaranPiutangController::class, 'printPaymentKhusus'])->name('printPayment');
                    Route::get('/print-all/{hutang_id}', [PembayaranPiutangController::class, 'printAllKhusus'])->name('admin.piutang.pembayaran.rutin.printAll');
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
            Route::get('/invoice/preview/{id}', [WithdrawController::class, 'previewInvoice'])->name('invoice.preview');
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

    Route::resource('manage-user', UserController::class);
    Route::get('manage-user/data', [UserController::class, 'data'])->name('manage-user.data');
    Route::post('/manage-user/import', [UserController::class, 'import'])->name('manage-user.import');
});

// User Routes
Route::middleware(['auth', 'verified', 'role:user'])->group(function () {

    Route::get('/user/dashboard', [AnggotaController::class, 'dashboard'])->name('user.dashboard');
    
    Route::get('/report/invoice', [MonthlyPaymentController::class, 'indexReportUser'])->name('user.laporan-bulanan');
    Route::post('/exportInvoice', [MonthlyPaymentController::class, 'exportInvoiceReport'])->name('export.invoice-user');

    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
        //route history pembayaran
        Route::group(['prefix' => 'history', 'as' => 'history.'], function () {
            Route::get('/main', [PaymentHistoryController::class, 'main'])->name('main');
            Route::get('/main/ajax', [PaymentHistoryController::class, 'mainDatatable'])->name('main.ajax');
            Route::get('/main/print', [PaymentHistoryController::class, 'mainPrint'])->name('main.print');

            Route::get('/monthly', [PaymentHistoryController::class, 'monthly'])->name('monthly');
            Route::get('/monthly/ajax', [PaymentHistoryController::class, 'monthlyDatatable'])->name('monthly.ajax');
            Route::get('/monthly/print', [PaymentHistoryController::class, 'monthlyPrint'])->name('monthly.print');

            Route::get('/other', [PaymentHistoryController::class, 'other'])->name('other');
            Route::get('/other/ajax', [PaymentHistoryController::class, 'otherDatatable'])->name('other.ajax');
            Route::get('/other/print', [PaymentHistoryController::class, 'otherPrint'])->name('other.print');
        });
        //end route history pembayaran
    });
});


// Route::middleware(['auth', 'verified', 'role:admin'])->resource('manage-user', UserController::class);
// Route::get('/manage-user/export/pdf', [UserController::class, 'exportPDF'])->name('manage-user.export.pdf');


Route::prefix('user')->middleware('auth')->group(function () {
    Route::get('/history-piutang', [HistoryPiutangController::class, 'index'])->name('user.history-piutang');
    Route::get('/history-piutang/{id}', [HistoryPiutangController::class, 'detail'])->name('user.history-piutang.detail');
    Route::get('/history-piutang/print/{hutang_id}', [HistoryPiutangController::class, 'printAll'])->name('user.history-piutang.print');

    Route::get('/change-password', [AuthController::class, 'changePassword'])->name('change.password');
    Route::post('/ganti-password', [AuthController::class, 'updatePassword'])->name('password.update');

});
