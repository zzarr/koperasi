<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigInterest extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dengan nama model
    protected $table = 'configInterst';

    // Tentukan primary key jika menggunakan UUID
    protected $keyType = 'string';
    public $incrementing = false;

    // Tentukan kolom yang dapat diisi secara massal
    protected $fillable = [
        'name',
        'interest_rate',
        'is_active',
    ];
}
