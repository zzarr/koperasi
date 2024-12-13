<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PembayaranPiutang;
use App\Models\ConfigPayment;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Piutang;
use Illuminate\Http\Request;

class PembayaranPiutangController extends Controller
{

    public function showRutinDetail($id)
    {
        $piutang = Piutang::findOrFail($id);
        $meta = ConfigPayment::where('name', 'dept_routine')->first();
        if ($piutang->jenis_hutang !== 'rutin') {
            abort(404);
        }
        $sisaHutang = Piutang::where('id', $id)->value('sisa');

        return view('admin.piutang.rutin_detail', [
            'piutang' => $piutang,
            'hutang_id' => $piutang->id,
            'sisa' => $sisaHutang,
            'nominal'   => ($piutang->jumlah_hutang / $piutang->jumlah_bulan) + ($piutang->jumlah_hutang * $meta->paid_off_amount / 100)
        ]);
    }

    public function showKhususDetail($id)
    {
        $piutang = Piutang::findOrFail($id);
        if ($piutang->jenis_hutang !== 'khusus') {
            abort(404);
        }
        $sisaHutang = Piutang::where('id', $id)->value('sisa');
        return view('admin.piutang.khusus_detail', [
            'piutang' => $piutang,
            'hutang_id' => $piutang->id,
            'sisa' => $sisaHutang
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

    public function printAllRutin($hutang_id)
    {
        // Mengambil semua pembayaran yang sesuai dengan hutang_id
        $pembayaran = PembayaranPiutang::with('piutang.user') // Memuat relasi piutang dan user
            ->where('hutang_id', $hutang_id)
            ->get();

        if ($pembayaran->isEmpty()) {
            return abort(404, 'Data tidak ditemukan.');
        }

        // Menyaring hanya username yang unik
        $bayarPokok = $pembayaran->sum('jumlah_bayar_pokok');
        $bayarBunga = $pembayaran->sum('jumlah_bayar_bunga');

        $sisaHutang = Piutang::find($hutang_id)->sisa;
        $totalPembayaran = $bayarBunga + $bayarPokok;
        $totalHutang = $sisaHutang+$totalPembayaran; // Mengambil jumlah hutang dari data piutang pertama

        // Menghitung sisa hutang

        return view('admin.piutang.rutin_print_all', [
            'pembayaran' => $pembayaran,
            'usernames' => $pembayaran[0]->piutang->user->name, // Hanya kirim username unik
            'hutang_id' => $hutang_id,
            'sisaHutang' => $sisaHutang,
            'totalHutang' => $totalHutang,
            'totalBayar' => $totalPembayaran,
        ]);
    }

    public function printAllKhusus($hutang_id)
    {
        // Mengambil semua pembayaran yang sesuai dengan hutang_id
        // Mengambil semua pembayaran yang sesuai dengan hutang_id
        $pembayaran = PembayaranPiutang::with('piutang.user') // Memuat relasi piutang dan user
        ->where('hutang_id', $hutang_id)
            ->get();

        if ($pembayaran->isEmpty()) {
            return abort(404, 'Data tidak ditemukan.');
        }

        // Menyaring hanya username yang unik
        $bayarPokok = $pembayaran->sum('jumlah_bayar_pokok');
        $bayarBunga = $pembayaran->sum('jumlah_bayar_bunga');

        $sisaHutang = Piutang::find($hutang_id)->sisa;
        $totalPembayaran = $bayarBunga + $bayarPokok;
        $totalHutang = $sisaHutang+$totalPembayaran; // Mengambil jumlah hutang dari data piutang pertama

        return view('admin.piutang.khusus_print_all', [
            'pembayaran' => $pembayaran,
            'usernames' => $pembayaran[0]->piutang->user->name, // Hanya kirim username unik
            'hutang_id' => $hutang_id,
            'sisaHutang' => $sisaHutang,
            'totalHutang' => $totalHutang,
            'totalBayar' => $totalPembayaran,
        ]);
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
                    // Ambil data bunga dari tabel configpayment berdasarkan nama 'dept_routine'
            $configPayment = ConfigPayment::where('name', 'dept_routine')->first();
            if (!$configPayment) {
                return response()->json(['message' => 'Konfigurasi pembayaran untuk "dept_routine" tidak ditemukan'], 404);
            }

            // Hitung jumlah_bayar_bunga berdasarkan persentase dari configpayment
            $persenBunga = $configPayment->paid_off_amount / 100; // Misalkan amount disimpan dalam persen
            $piutang = Piutang::findOrFail($validatedData['hutang_id']);

            $jumlahBayarBunga = ($piutang->jumlah_hutang * $persenBunga);
            $jumlahBayarPokokSetelahDikurangi = $validatedData['jumlah_bayar_pokok'] - $jumlahBayarBunga;
            $latestPaymentCount = PembayaranPiutang::where('hutang_id', $piutang->id)->count();
            $pembayaranKe = $latestPaymentCount + 1;

            PembayaranPiutang::create([
                'hutang_id' => $piutang->id,
                'pembayaran_ke' => $pembayaranKe,
                'tanggal_pembayaran' => $validatedData['tanggal_pembayaran'],
                'jumlah_bayar_pokok' => $jumlahBayarPokokSetelahDikurangi,
                'jumlah_bayar_bunga' => $jumlahBayarBunga,
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

    public function storeKhusus(Request $request)
    {
        $cleanedJumlahPokok = str_replace(['Rp', '.', ' '], '', $request->jumlah_bayar_pokok);
        $request->merge(['jumlah_bayar_pokok' => $cleanedJumlahPokok]);
        $cleanedJumlahBunga = str_replace(['Rp', '.', ' '], '', $request->jumlah_bayar_bunga);
        $request->merge(['jumlah_bayar_bunga' => $cleanedJumlahBunga]);

        $validatedData = $request->validate([
            'hutang_id' => 'required|exists:piutangs,id',
            'tanggal_pembayaran' => 'required|date',
            'jumlah_bayar_pokok' => 'required|numeric|min:0',
            'jumlah_bayar_bunga' => 'required|numeric|min:0',
            'catatan' => 'nullable|string|max:255',
        ]);

        try {
            // Ambil data bunga dari tabel configpayment berdasarkan nama 'dept_routine'
            $configPayment = ConfigPayment::where('name', 'dept_routine')->first();
            if (!$configPayment) {
                return response()->json(['message' => 'Konfigurasi pembayaran untuk "dept_routine" tidak ditemukan'], 404);
            }

            // Hitung jumlah_bayar_bunga berdasarkan persentase dari configpayment
            $persenBunga = $configPayment->paid_off_amount / 100; // Misalkan amount disimpan dalam persen
            $piutang = Piutang::findOrFail($validatedData['hutang_id']);
            $latestPaymentCount = PembayaranPiutang::where('hutang_id', $piutang->id)->count();
            $pembayaranKe = $latestPaymentCount + 1;

            PembayaranPiutang::create([
                'hutang_id' => $piutang->id,
                'pembayaran_ke' => $pembayaranKe,
                'tanggal_pembayaran' => $validatedData['tanggal_pembayaran'],
                'jumlah_bayar_pokok' => $request->jumlah_bayar_pokok,
                'jumlah_bayar_bunga' => $request->jumlah_bayar_bunga,
                'catatan' => $validatedData['catatan']  ?? '-',
            ]);


            $sisa = $piutang->sisa - ($validatedData['jumlah_bayar_pokok'] + $validatedData['jumlah_bayar_bunga']);

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
