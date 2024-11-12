<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visi extends Model
{
    use HasFactory;

    protected $table = 'visis';

    protected $fillable = [
        'judul', 'keterangan','keterangan2', 'gambar'
    ];


    protected $hidden = [];
}
