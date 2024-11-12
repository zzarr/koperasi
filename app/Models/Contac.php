<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contac extends Model
{
    use HasFactory;

    protected $table = 'contacs';

    protected $fillable = [
        'judul', 'keterangan', 'gambar'
    ];


    protected $hidden = [];
}
