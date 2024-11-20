<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Support\Str;

class MainPayment extends Model
{
    use HasFactory, SoftDeletes;

   // Pastikan untuk menggunakan UUID sebagai primary key
   protected $keyType = 'string';
   public $incrementing = false;  // Matikan auto-increment
   
   // Secara otomatis menghasilkan UUID untuk id
   protected static function boot()
   {
       parent::boot();
       static::creating(function ($model) {
           if (!$model->id) {
               $model->id = (string) Str::uuid();  // Menghasilkan UUID secara manual
           }
       });
   }

    protected $primaryKey = 'id';

    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function configPayment(){
        return $this->belongsTo(ConfigPayment::class, 'config_payment_id', 'id');
    }
}
