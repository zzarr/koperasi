<?php

use Illuminate\Support\Facades\Route;
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

//andin
Route::get('/dashboard/admin', function () {
    return view('admin.dashboard');
});
Route::get('admin/metadata/datatables', [ManageMetaDataController::class, 'datatable'])->name('metadata.data');
Route::get('/admin/metadata', [ManageMetaDataController::class, 'index'])->name('manage_metadata');
Route::post('/admin/metadata', [ManageMetaDataController::class, 'store'])->name('manage_metadata.store');
Route::put('/admin/metadata/update/{id}', [ManageMetaDataController::class, 'update'])->name('manage_metadata.update');


//MasL
Route::get('/dashboard/user', function () {
    return view('user.dashboard');
});
