<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Piutang;
use App\Models\PembayaranPiutang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class HistoryPiutangController extends Controller
{
    /**
     * Menampilkan halaman utama history hutang
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Ambil data piutang yang dimiliki oleh user yang sedang login
            $data = Piutang::where('user_id', Auth::id())->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) {
                    return '<a href="' . route('user.history-piutang.detail', $row->id) . '" class="btn btn-info btn-sm">Detail</a>';
                })
                ->editColumn('jumlah_hutang', function ($row) {
                    return number_format($row->jumlah_hutang, 0, ',', '.');
                })
                ->editColumn('sisa', function ($row) {
                    // Hitung sisa hutang
                    $totalPembayaran = PembayaranPiutang::where('hutang_id', $row->id)->sum('jumlah_bayar_pokok') + PembayaranPiutang::where('hutang_id', $row->id)->sum('jumlah_bayar_bunga');
                    $sisa = $row->jumlah_hutang - $totalPembayaran;
                    return number_format($sisa, 0, ',', '.');
                })
                ->editColumn('is_lunas', function ($row) {
                    return $row->is_lunas ? 'Lunas' : 'Belum Lunas';
                })
                ->rawColumns(['aksi']) // Pastikan kolom aksi dirender sebagai HTML
                ->make(true);
        }

        return view('user.history-hutang');
    }

    /**
     * Menampilkan detail piutang tertentu
     */
    public function detail($id)
    {
        $piutang = Piutang::where('id', $id)->where('user_id', Auth::id())->first();

        if (!$piutang) {
            return redirect()->route('user.history-piutang')->with('error', 'Piutang tidak ditemukan atau tidak milik Anda.');
        }

        if (request()->ajax()) {
            $pembayarans = PembayaranPiutang::where('hutang_id', $piutang->id)->get();

            return DataTables::of($pembayarans)
                ->addIndexColumn()
                ->editColumn('jumlah_pembayaran', function ($row) {
                    return number_format($row->jumlah_bayar_pokok + $row->jumlah_bayar_bunga, 0, ',', '.');
                })
                ->make(true);
        }

        return view('user.detail-piutang', compact('piutang'));
    }
}
