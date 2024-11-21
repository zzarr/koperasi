<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PembayaranPiutang;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Piutang;
use Illuminate\Http\Request;

class PembayaranPiutangController extends Controller
{
    
    // public function showDetail($id)
    // {
    //     // Cari data piutang berdasarkan ID
    //     $piutang = Piutang::findOrFail($id);

    //     // Kirimkan data ke view detail pembayaran hutang
    //     return view('admin.piutang.pembayaran', compact('piutang'));
    // }

    public function showRutinDetail($id)
    {
        $piutang = Piutang::findOrFail($id); // Ambil data piutang berdasarkan ID
        if ($piutang->jenis_hutang !== 'rutin') {
            abort(404); // Jika jenis hutang bukan rutin, kembalikan 404
        }

        return view('admin.piutang.rutin_detail', compact('piutang')); // Tampilkan view untuk rutin
    }

    public function showKhususDetail($id)
    {
        $piutang = Piutang::findOrFail($id); // Ambil data piutang berdasarkan ID
        if ($piutang->jenis_hutang !== 'khusus') {
            abort(404); // Jika jenis hutang bukan khusus, kembalikan 404
        }

        return view('admin.piutang.khusus_detail', compact('piutang')); // Tampilkan view untuk khusus
    }


    public function datatables(Request $request)
    { {
            $data = PembayaranPiutang::all();
            return DataTables::of($data)->make(true);
        }
    }

        public function getPiutang($id)
    {
        $piutang = Piutang::findOrFail($id); // Ambil data berdasarkan ID
        return response()->json($piutang); // Kembalikan data dalam bentuk JSON
    }

    public function storeKhusus(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|exists:users,id', // Validasi harus sesuai ID user
            'jenis_hutang' => 'required|string',
            'jumlah_bulan' => 'required|integer|min:1|max:12',
            'jumlah_hutang' => 'required|numeric|min:0',
        ]);
    
        try {
            // Simpan data ke database
            Piutang::create([
                'user_id' => $validatedData['nama'],
                'jenis_hutang' => $validatedData['jenis_hutang'],
                'jumlah_bulan' => $validatedData['jumlah_bulan'],
                'jumlah_hutang' => $validatedData['jumlah_hutang'],
                'sisa' => $validatedData['jumlah_hutang'], // Misalnya, sisa sama dengan jumlah awal
                'is_lunas' => 0, // Default belum lunas
            ]);
    
            return response()->json(['message' => 'Data berhasil disimpan'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat menyimpan data'], 500);
        }
    }


}
