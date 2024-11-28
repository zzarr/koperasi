<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranPiutang extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dengan nama model
    protected $table = 'pembayaran_piutangs';

    // Tentukan kolom yang dapat diisi secara massal
    protected $fillable = [
        'hutang_id',
        'pembayaran_ke',
        'jumlah_bayar_pokok',
        'jumlah_bayar_bunga',
        'tanggal_pembayaran',
        'catatan',
    ];

    // Mengonfigurasi relasi dengan model Piutang
    public function piutang()
    {
        return $this->belongsTo(Piutang::class, 'hutang_id', 'id');
    }

    public function updatePiutangStatus()
{
    // Ambil data piutang terkait dengan pembayaran
    $piutang = Piutang::find($this->hutang_id); // Pastikan kolom hutang_id diisi dengan ID piutang

    if (!$piutang) {
        return false; // Jika piutang tidak ditemukan
    }

    // Hitung total pembayaran
    $totalBayar = $this->jumlah_bayar_pokok + $this->jumlah_bayar_bunga;

    // Kurangi sisa dari piutang
    $piutang->sisa -= $totalBayar;

    // Jika sisa menjadi 0 atau kurang, set is_lunas menjadi 1
    if ($piutang->sisa <= 0) {
        $piutang->is_lunas = 1;
    }

    // Simpan perubahan
    return $piutang->save();
}


}


