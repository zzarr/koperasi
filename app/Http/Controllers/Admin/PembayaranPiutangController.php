<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PembayaranPiutang;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Piutang;
use Illuminate\Http\Request;

class PembayaranPiutangController extends Controller
{
    
    public function showRutinDetail($id)
    {
        $piutang = Piutang::findOrFail($id); 
        if ($piutang->jenis_hutang !== 'rutin') {
            abort(404); 
        }

        return view('admin.piutang.rutin_detail', [
            'piutang' => $piutang,
            'hutang_id' => $piutang->id 
        ]);
    }

    public function showKhususDetail($id)
    {
        $piutang = Piutang::findOrFail($id); 
        if ($piutang->jenis_hutang !== 'khusus') {
            abort(404); 
        }
        return view('admin.piutang.khusus_detail', [
            'piutang' => $piutang,
            'hutang_id' => $piutang->id 
        ]);
    }


    public function datatablesKhusus(Request $request)
    {
        $hutangId = $request->input('hutang_id'); 
        $data = PembayaranPiutang::where('hutang_id', $hutangId) 
            ->whereHas('piutang', function ($query) {
                $query->where('jenis_hutang', 'khusus'); 
            })
            ->get();
        return DataTables::of($data)->make(true);
    }

    public function datatablesRutin(Request $request)
    {
        $hutangId = $request->input('hutang_id'); 
        $data = PembayaranPiutang::where('hutang_id', $hutangId)
            ->whereHas('piutang', function ($query) {
                $query->where('jenis_hutang', 'rutin'); 
            })
            ->get();
    
        return DataTables::of($data)->make(true);
    }
    
    public function printPaymentKhusus($paymentId)
    {
        $payment = PembayaranPiutang::with('piutang.user')->find($paymentId);
        if (!$payment) {
            return abort(404, 'Data pembayaran tidak ditemukan.');
        }
    
        return view('admin.piutang.invoice_khusus', ['data' => $payment]);
    }

    public function printPaymentRutin($paymentId)
    {
        $payment = PembayaranPiutang::with('piutang.user')->find($paymentId);
        if (!$payment) {
            return abort(404, 'Data pembayaran tidak ditemukan.');
        }
        return view('admin.piutang.invoice_rutin', ['data' => $payment]);
    }
    
    public function getPiutang($id)
    {
        $piutang = Piutang::findOrFail($id);
        return response()->json($piutang);
    }

 



    public function storeRutin(Request $request)
    {
        $cleanedJumlahPokok = str_replace(['Rp', '.', ' '], '', $request->jumlah_bayar_pokok);
        $request->merge(['jumlah_bayar_pokok' => $cleanedJumlahPokok]);
        $cleanedJumlahBunga = str_replace(['Rp', '.', ' '], '', $request->jumlah_bayar_bunga);
        $request->merge(['jumlah_bayar_bunga' => $cleanedJumlahBunga]);

        $validatedData = $request->validate([
            'hutang_id' => 'required|exists:piutangs,id',
            'tanggal_pembayaran' => 'required|date', 
            'jumlah_bayar_pokok' => 'required|numeric|min:0', 
            'catatan' => 'nullable|string|max:255',
        ]);
    
        try {
            $piutang = Piutang::findOrFail($validatedData['hutang_id']);
            $latestPaymentCount = PembayaranPiutang::where('hutang_id', $piutang->id)->count();
            $pembayaranKe = $latestPaymentCount + 1;
    
            PembayaranPiutang::create([
                'hutang_id' => $piutang->id, 
                'pembayaran_ke' => $pembayaranKe, 
                'tanggal_pembayaran' => $validatedData['tanggal_pembayaran'],
                'jumlah_bayar_pokok' => $validatedData['jumlah_bayar_pokok'],
                'jumlah_bayar_bunga' => 0,
                'catatan' => $validatedData['catatan']  ?? '-',
            ]);


            $sisa = $piutang->sisa - $validatedData['jumlah_bayar_pokok'];

            if ($sisa <= 0) {
                $piutang->update([
                    'is_lunas' => 1,
                    'sisa' => 0, // Sisa dianggap sudah lunas
                ]);
            } else {
                // Jika belum lunas, update sisa hutang
                $piutang->update([
                    'sisa' => $sisa,
                ]);
            }
    
            return response()->json(['message' => 'Data berhasil disimpan'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()], 500);
        }
    }
    
}
