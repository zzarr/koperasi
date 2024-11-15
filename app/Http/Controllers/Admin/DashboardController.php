<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Menghitung total simpanan
        $simpananPokok = Wallet::sum('main');
        $simpananWajib = Wallet::sum('monthly');
        $simpananSukarela = Wallet::sum('other');

        // Menghitung total hutang berdasarkan jenis
        $hutang_rutin = DB::table('piutangs')
            ->where('jenis_hutang', 'rutin')
            ->sum('jumlah_hutang');

        $hutang_khusus = DB::table('piutangs')
            ->where('jenis_hutang', 'khusus')
            ->sum('jumlah_hutang');

        // Menghitung total wallet user yang sedang login
        $wallets = DB::table('wallets')
            ->where('user_id', Auth::user()->id)
            ->sum('total');

        // Menghitung jumlah pengguna
        $jumlah_user = User::count();

        // Menyiapkan data untuk dikirim ke view
        $data = [
            'jumlah_user' => $jumlah_user,
            'simpananPokok' => $simpananPokok,
            'simpananWajib' => $simpananWajib,
            'simpananSukarela' => $simpananSukarela,
            'hutang_rutin' => $hutang_rutin,
            'hutang_khusus' => $hutang_khusus,
            'wallets' => $wallets,
        ];

        return view('admin.dashboard', $data);
    }

    public function loginmember(Request $request)
    {
        Auth::loginUsingId($request->input('id_login'));
        return response()->json(['error' => false]);
    }
}
