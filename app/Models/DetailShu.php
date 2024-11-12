<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailShu extends Model
{
    use HasFactory, Uuid;

    // In Laravel 6.0+ make sure to also set $keyType
    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    protected $guarded = [];

    public function meta_shu(){
        return $this->belongsTo(MetaShu::class);
    }
}
