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
     * Menampilkan halaman utama history piutang
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Ambil data piutang yang dimiliki oleh user yang sedang login
            $data = Piutang::where('user_id', Auth::id())->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) {
                    // Tombol aksi untuk detail
                    return '<a href="' . route('user.history-piutang.detail', $row->id) . '" class="btn btn-info btn-sm">Detail</a>';
                })
                ->editColumn('jumlah_hutang', function ($row) {
                    return number_format($row->jumlah_hutang, 0, ',', '.');
                })
                ->editColumn('sisa', function ($row) {
                    return number_format($row->sisa, 0, ',', '.');
                })
                ->editColumn('is_lunas', function ($row) {
                    // Menampilkan status Lunas atau Belum Lunas
                    return $row->is_lunas ? 'Lunas' : 'Belum Lunas';
                })
                ->rawColumns(['aksi']) // Pastikan kolom aksi dapat dirender sebagai HTML
                ->make(true);
        }

        // Jika bukan request Ajax, kembalikan tampilan view
        return view('user.history-hutang');
    }

    /**
     * Menampilkan detail piutang tertentu
     */
    public function detail($id)
    {
        // Cari piutang berdasarkan ID dan pastikan itu milik user yang sedang login
        $piutang = Piutang::where('id', $id)->where('user_id', Auth::id())->first();

        // Jika piutang tidak ditemukan, redirect ke history piutang
        if (!$piutang) {
            return redirect()->route('user.history-piutang')->with('error', 'Piutang tidak ditemukan atau tidak milik Anda.');
        }

        // Ambil data pembayaran terkait dengan piutang menggunakan model PembayaranPiutang
        if (request()->ajax()) {
            $pembayarans = PembayaranPiutang::where('hutang_id', $piutang->id)->get();

            return DataTables::of($pembayarans)
                ->addIndexColumn()
                ->editColumn('jumlah_pembayaran', function ($row) {
                    return number_format($row->jumlah_pembayaran, 0, ',', '.');
                })
                ->make(true);
        }

        // Kirim data detail piutang dan data pembayaran ke view
        return view('user.detail-piutang', compact('piutang'));
    }
}
