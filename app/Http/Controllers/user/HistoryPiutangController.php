<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Piutang;
use App\Models\PembayaranPiutang;
use Illuminate\Support\Facades\Auth;

class HistoryPiutangController extends Controller
{
    // Menampilkan halaman utama dengan daftar piutang dan detail pembayaran (jika ada)
    public function index($id = null)
    {
        // Ambil semua piutang milik user yang sedang login
        $piutangs = Piutang::where('user_id', Auth::id())->get();

        $detailPiutang = null;
        $pembayarans = [];

        // Jika ada ID, ambil data detail piutang dan pembayaran
        if ($id) {
            $detailPiutang = Piutang::where('id', $id)->where('user_id', Auth::id())->first();

            // Jika piutang tidak ditemukan atau bukan milik user
            if (!$detailPiutang) {
                return redirect()->route('user.history-piutang')->with('error', 'Piutang tidak ditemukan atau tidak milik Anda.');
            }

            // Ambil data pembayaran terkait
            $pembayarans = PembayaranPiutang::where('hutang_id', $id)->get();
        }

        // Tampilkan satu view untuk semua
        return view('user.history-hutang', compact('piutangs', 'detailPiutang', 'pembayarans'));
    }
}
