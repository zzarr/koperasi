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
        'pembayaran ke-',
        'jumlah_bayar_pokok',
        'jumlah_bayar_bunga',
        'tanggal_pembayaran',
    ];

    // Mengonfigurasi relasi dengan model Piutang
    public function piutang()
    {
        return $this->belongsTo(Piutang::class, 'hutang_id');
    }
}
