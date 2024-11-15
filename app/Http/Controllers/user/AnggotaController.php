<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AnggotaController extends Controller
{
    public function dashboard()
	{
		$get_member=DB::table('users')->where('id',Auth::user()->id)->first();

		// $getpoin=DB::table('tb_poin_transaksi')->where('id_user',@$get_member->member_id)->where('status','aktif')->orderBy('tanggal_poin','DESC')->paginate(20);
   
		//    $jumlah_poin         = DB::table('tb_poin_transaksi')->where('id_user',@$get_member->member_id)->sum('jumlah_poin');
		//    $digunakan         = DB::table('tb_poin_dipakai')->where('id_user',@$get_member->member_id)->sum('poin');
	
		// $jumlah_poin= DB::table('tb_poin_transaksi')->where('id_user',@$get_member->member_id)->sum('jumlah_poin');
		$other_payments = DB::table('other_payments')->where('user_id', Auth::user()->id)->sum('amount');
		$main_payments = DB::table('main_payments')->where('user_id', Auth::user()->id)->sum('amount');
		$monthly_payments = DB::table('monthly_payments')->where('user_id', Auth::user()->id)->sum('amount');
		$hutang_rutin = DB::table('piutangs')
		->where('user_id', Auth::user()->id)
		->where('jenis_hutang', 'rutin')
		->sum('jumlah_hutang');
		$hutang_khusus = DB::table('piutangs')
		->where('user_id', Auth::user()->id)
		->where('jenis_hutang', 'khusus')
		->sum('jumlah_hutang');
		$wallets = DB::table('wallets')->where('user_id', Auth::user()->id)->sum('total');

		// $shu = Wallet::where('user_id', Auth::user()->id)->first()->shu;

		return view('user.dashboard', compact('other_payments', 'main_payments', 'monthly_payments', 'hutang_rutin', 'hutang_khusus'));
	}
}
