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

        return view('admin.piutang.rutin_detail', [
            'piutang' => $piutang,
            'hutang_id' => $piutang->id // Kirim hutang_id ke view
        ]);// Tampilkan view untuk rutin
    }

    public function showKhususDetail($id)
{
    $piutang = Piutang::findOrFail($id); // Ambil data piutang berdasarkan ID
    if ($piutang->jenis_hutang !== 'khusus') {
        abort(404); // Jika jenis hutang bukan khusus, kembalikan 404
    }

    // Kirim juga 'id' sebagai 'hutang_id' ke view
    return view('admin.piutang.khusus_detail', [
        'piutang' => $piutang,
        'hutang_id' => $piutang->id // Kirim hutang_id ke view
    ]);
}


public function datatablesKhusus(Request $request)
{
    $hutangId = $request->input('hutang_id'); // Ambil hutang_id dari request

    // Pastikan 'hutang_id' difilter dan jenis_hutang adalah 'khusus'
    $data = PembayaranPiutang::where('hutang_id', $hutangId) // Filter berdasarkan hutang_id
        ->whereHas('piutang', function ($query) {
            $query->where('jenis_hutang', 'khusus'); // Filter jenis_hutang 'khusus'
        })
        ->get();

    // Mengembalikan data dalam format DataTables
    return DataTables::of($data)->make(true);
}





    

    public function datatablesRutin(Request $request)
    {
        $hutangId = $request->input('hutang_id'); // Ambil hutang_id dari request
    
        // Pastikan 'hutang_id' difilter dan jenis_hutang adalah 'khusus'
        $data = PembayaranPiutang::where('hutang_id', $hutangId) // Filter berdasarkan hutang_id
            ->whereHas('piutang', function ($query) {
                $query->where('jenis_hutang', 'rutin'); // Filter jenis_hutang 'khusus'
            })
            ->get();
    
        // Mengembalikan data dalam format DataTables
        return DataTables::of($data)->make(true);
    }
    
    
    public function printPaymentKhusus($paymentId)
    {
        // Ambil data pembayaran beserta data user terkait
        $payment = PembayaranPiutang::with('piutang.user')->find($paymentId);
    
        if (!$payment) {
            return abort(404, 'Data pembayaran tidak ditemukan.');
        }
    
        // Kirim data ke view cetak
        return view('admin.piutang.invoice_khusus', ['data' => $payment]);
    }

    public function printPaymentRutin($paymentId)
    {
        // Ambil data pembayaran beserta data user terkait
        $payment = PembayaranPiutang::with('piutang.user')->find($paymentId);
    
        if (!$payment) {
            return abort(404, 'Data pembayaran tidak ditemukan.');
        }
    
        // Kirim data ke view cetak
        return view('admin.piutang.invoice_rutin', ['data' => $payment]);
    }
    
    



        public function getPiutang($id)
    {
        $piutang = Piutang::findOrFail($id); // Ambil data berdasarkan ID
        return response()->json($piutang); // Kembalikan data dalam bentuk JSON
    }

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
