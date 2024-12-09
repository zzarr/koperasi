<?php

namespace App\Http\Controllers\user;

use App\Models\User;
use App\Models\Wallet;
use App\Models\OtherPayment;
use App\Models\MainPayment;
use App\Models\MonthlyPayment;
use App\Models\Piutang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AnggotaController extends Controller
{


	// public function dashboard()
	// {
	// 	$userId = Auth::id();
	
	// 	// Jumlah pembayaran lainnya
	// 	$other_payments = OtherPayment::where('user_id', $userId)->sum('amount');
	
	// 	// Jumlah pembayaran utama
	// 	$main_payments = MainPayment::where('user_id', $userId)->sum('amount');
	
	// 	// Jumlah pembayaran bulanan
	// 	$monthly_payments = MonthlyPayment::where('user_id', $userId)->sum('amount');
	
	// 	// Hutang rutin
	// 	$hutang_rutin = Piutang::where('user_id', $userId)
	// 		->where('jenis_hutang', 'rutin')
	// 		->sum('jumlah_hutang');
	
	// 	// Hutang khusus
	// 	$hutang_khusus = Piutang::where('user_id', $userId)
	// 		->where('jenis_hutang', 'khusus')
	// 		->sum('jumlah_hutang');
	
	// 	// Total dompet
		
	
	// 	$wallets = DB::table('wallets')->where('user_id', $userId)->sum('total');


		


	
	// 	return view('user.dashboard', compact(
	// 		'other_payments',
	// 		'main_payments',
	// 		'monthly_payments',
	// 		'hutang_rutin',
	// 		'hutang_khusus',
	// 		'wallets'
	// 	));
	// }


	public function dashboard()
{
    $userId = Auth::id();

    // Jumlah pembayaran lainnya
    $other_payments = DB::table('other_payments')->where('user_id', $userId)->sum('amount');

    // Jumlah pembayaran utama
    $main_payments = DB::table('main_payments')->where('user_id', $userId)->sum('amount');

    // Jumlah pembayaran bulanan
    $monthly_payments = DB::table('monthly_payments')->where('user_id', $userId)->sum('amount');

    // Hutang rutin
    $hutang_rutin = DB::table('piutangs')
        ->where('user_id', $userId)
        ->where('jenis_hutang', 'rutin')
        ->sum('jumlah_hutang');

    // Hutang khusus
    $hutang_khusus = DB::table('piutangs')
        ->where('user_id', $userId)
        ->where('jenis_hutang', 'khusus')
        ->sum('jumlah_hutang');

    // Total saldo wallet
    $wallets = DB::table('wallets')->where('user_id', $userId)->sum('total');

    return view('user.dashboard', compact(
        'other_payments',
        'main_payments',
        'monthly_payments',
        'hutang_rutin',
        'hutang_khusus',
        'wallets'
    ));
}

	

}
