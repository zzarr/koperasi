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


//     public function datatablesKhusus(Request $request)
// {
//     // Ambil parameter hutang_id dari request
//     $hutangId = $request->input('hutang_id');

//     // Filter data berdasarkan hutang_id dan jenis_hutang = 'khusus'
//     $data = PembayaranPiutang::whereHas('piutang', function ($query) {
//             $query->where('jenis_hutang', 'khusus'); // Filter jenis_hutang "khusus"
//         })
//         ->when($hutangId, function ($query, $hutangId) {
//             return $query->where('hutang_id', $hutangId); // Filter berdasarkan hutang_id
//         })->get();

//     // Mengembalikan data dalam format DataTables
//     return DataTables::of($data)->make(true);
// }


public function datatablesKhusus(Request $request)
{
    // Ambil hutang_id dari request jika ada
    $hutangId = $request->input('hutang_id'); // Pastikan 'hutang_id' ada di URL/parameter request

    // Filter berdasarkan hutang_id dan jenis_hutang 'khusus'
    $data = PembayaranPiutang::when($hutangId, function ($query, $hutangId) {
        return $query->where('hutang_id', $hutangId); // Filter berdasarkan hutang_id
    })
    ->whereHas('piutang', function ($query) {
        $query->where('jenis_hutang', 'khusus'); // Filter jenis_hutang 'khusus'
    })
    ->get();

    // Mengembalikan data dalam format DataTables
    return DataTables::of($data)->make(true);
}




    

    public function datatablesRutin(Request $request)
    {
        // Ambil parameter hutang_id dan jenis_hutang dari request
        $hutangId = $request->input('hutang_id');
        $jenisHutang = $request->input('jenis_hutang', 'rutin'); // Default jenis_hutang adalah "rutin"
    
        // Filter data berdasarkan hutang_id dan jenis_hutang
        $data = PembayaranPiutang::select('pembayaran_ke', 'tanggal_pembayaran', 'jumlah_bayar_pokok')
            ->whereHas('piutang', function ($query) use ($jenisHutang) {
                $query->where('jenis_hutang', $jenisHutang); // Filter berdasarkan jenis_hutang
            })
            ->when($hutangId, function ($query, $hutangId) {
                return $query->where('hutang_id', $hutangId); // Filter berdasarkan hutang_id
            })->get();
    
        // Mengembalikan data dalam format DataTables
        return DataTables::of($data)->make(true);
    }
    
    




        public function getPiutang($id)
    {
        $piutang = Piutang::findOrFail($id); // Ambil data berdasarkan ID
        return response()->json($piutang); // Kembalikan data dalam bentuk JSON
    }

    // public function storeKhusus(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'nama' => 'required|exists:users,id', // Validasi harus sesuai ID user
    //         'jenis_hutang' => 'required|string',
    //         'jumlah_bulan' => 'required|integer|min:1|max:12',
    //         'jumlah_hutang' => 'required|numeric|min:0',
    //     ]);
    
    //     try {
    //         // Simpan data ke database
    //         Piutang::create([
    //             'user_id' => $validatedData['nama'],
    //             'jenis_hutang' => $validatedData['jenis_hutang'],
    //             'jumlah_bulan' => $validatedData['jumlah_bulan'],
    //             'jumlah_hutang' => $validatedData['jumlah_hutang'],
    //         ]);
    
    //         return response()->json(['message' => 'Data berhasil disimpan'], 200);
    //     } catch (\Exception $e) {
    //         return response()->json(['message' => 'Terjadi kesalahan saat menyimpan data'], 500);
    //     }
    // }
    public function storeKhusus(Request $request)
    {
        // Validasi data yang dikirimkan
        $validatedData = $request->validate([
            'hutang_id' => 'required|exists:piutangs,id', // Validasi ID hutang (relasi dengan tabel piutangs)
            'tanggal_pembayaran' => 'required|date', // Validasi tanggal pembayaran
            'jumlah_bayar_pokok' => 'required|numeric|min:0', // Validasi nominal pokok
            'jumlah_bayar_bunga' => 'required|numeric|min:0', // Validasi nominal bunga
        ]);
    
        try {
            // Ambil data piutang berdasarkan hutang_id
            $piutang = Piutang::findOrFail($validatedData['hutang_id']);
    
            // Hitung jumlah pembayaran sebelumnya
            $latestPaymentCount = PembayaranPiutang::where('hutang_id', $piutang->id)->count();
    
            // Tentukan nilai pembayaran_ke
            $pembayaranKe = $latestPaymentCount + 1;
    
            // Simpan data pembayaran baru
            PembayaranPiutang::create([
                'hutang_id' => $piutang->id, // Menghubungkan ke piutang
                'pembayaran_ke' => $pembayaranKe, // Nilai otomatis
                'tanggal_pembayaran' => $validatedData['tanggal_pembayaran'],
                'jumlah_bayar_pokok' => $validatedData['jumlah_bayar_pokok'],
                'jumlah_bayar_bunga' => $validatedData['jumlah_bayar_bunga'],
            ]);
    
            return response()->json(['message' => 'Data berhasil disimpan'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()], 500);
        }
    }

    public function storeRutin(Request $request)
    {
        // Validasi data yang dikirimkan
        $validatedData = $request->validate([
            'hutang_id' => 'required|exists:piutangs,id', // Validasi ID hutang (relasi dengan tabel piutangs)
            'tanggal_pembayaran' => 'required|date', // Validasi tanggal pembayaran
            'jumlah_bayar_pokok' => 'required|numeric|min:0', // Validasi nominal pokok
            // 'jumlah_bayar_bunga' => 'required|numeric|min:0', 
        ]);
    
        try {
            // Ambil data piutang berdasarkan hutang_id
            $piutang = Piutang::findOrFail($validatedData['hutang_id']);
    
            // Hitung jumlah pembayaran sebelumnya
            $latestPaymentCount = PembayaranPiutang::where('hutang_id', $piutang->id)->count();
    
            // Tentukan nilai pembayaran_ke
            $pembayaranKe = $latestPaymentCount + 1;
    
            // Simpan data pembayaran baru
            PembayaranPiutang::create([
                'hutang_id' => $piutang->id, // Menghubungkan ke piutang
                'pembayaran_ke' => $pembayaranKe, // Nilai otomatis
                'tanggal_pembayaran' => $validatedData['tanggal_pembayaran'],
                'jumlah_bayar_pokok' => $validatedData['jumlah_bayar_pokok'],
                'jumlah_bayar_bunga' => 0,
            ]);
    
            return response()->json(['message' => 'Data berhasil disimpan'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()], 500);
        }
    }
    
    
    


     
    
    

}
