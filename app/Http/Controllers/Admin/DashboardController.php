<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
	public function index()
	{
		$simpananPokok = Wallet::sum('main');
		$simpananWajib = Wallet::sum('monthly');
		$simpananSukarela = Wallet::sum('other');
		$jumlah_user = User::all()->count();

		$data = [
			'jumlah_user' => $jumlah_user,
			'simpananPokok' => $simpananPokok,
			'simpananWajib' => $simpananWajib,
			'simpananSukarela' => $simpananSukarela,
		];
		return view('admin.dashboard',$data);
	}
	public function loginmember(Request $request)
	{
		Auth::loginUsingId($request->input('id_login'));
		print json_encode(array('error' => false));
	}
}
