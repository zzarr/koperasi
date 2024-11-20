<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PembayaranPiutang;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Piutang;
use Illuminate\Http\Request;

class PembayaranPiutangController extends Controller
{
    
    public function showDetail($id)
    {
        // Cari data piutang berdasarkan ID
        $piutang = Piutang::findOrFail($id);

        // Kirimkan data ke view detail pembayaran hutang
        return view('admin.piutang.pembayaran', compact('piutang'));
    }

    public function datatables(Request $request)
    { {
            $data = PembayaranPiutang::all();
            return DataTables::of($data)->make(true);
        }
    }


}
