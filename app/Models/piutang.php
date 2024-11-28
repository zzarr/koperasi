<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Piutang extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dengan nama model
    protected $table = 'piutangs';

    // Tentukan kolom yang dapat diisi secara massal (mass assignable)
    protected $fillable = [
        'id',
        'user_id',
        'jenis_hutang',
        'jumlah_hutang',
        'jumlah_bulan',
        'sisa',
        'is_lunas',
    ];

    // Mengonfigurasi relasi dengan model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pembayaranPiutang(){
        return $this->hasMany(PembayaranPiutang::class, 'hutang_id', 'id');
    }
}
