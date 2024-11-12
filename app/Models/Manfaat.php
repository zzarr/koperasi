<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manfaat extends Model
{
    use HasFactory;

    protected $table = 'manfaats';

    protected $fillable = [
        'judul', 'keterangan', 'gambar'
    ];


    protected $hidden = [];
}
