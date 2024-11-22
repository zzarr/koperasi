<?php

namespace App\Models;

use App\Traits\Uuid;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles, HasFactory, Notifiable;

    protected $fillable = [
        'email',
        'username',
        'password',
        'name',
        'phone_number',
        'address',
        'registered_at',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'id' => 'string',
    ];

    // Set primary key and type to UUID
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'id';

    // Set UUID before creating the user
    protected static function booted()
    {
        static::creating(function ($user) {
            if (empty($user->id)) {
                $user->id = (string) Str::uuid(); // Automatically generate UUID if id is not provided
            }
        });
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class, 'user_id');
    }

    public function mainPayment()
    {
        return $this->hasMany(MainPayment::class, 'user_id')->orderBy('created_at', 'ASC');
    }

    public function monthlyPayment()
    {
        return $this->hasMany(MonthlyPayment::class, 'user_id')->orderBy('payment_month', 'ASC');
    }

    public function otherPayment()
    {
        return $this->hasMany(OtherPayment::class, 'user_id')->orderBy('payment_month', 'ASC');
    }

    public function yearlyLog()
    {
        return $this->hasMany(YearlyLog::class, 'user_id');
    }

    public function piutangs()
    {
        return $this->hasMany(Piutang::class);
    }
}
