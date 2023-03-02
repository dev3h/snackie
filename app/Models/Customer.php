<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Customer extends Model implements AuthenticatableContract
{
    use HasFactory;
    use Notifiable;
    use Authenticatable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'shipping_id',
        // 'avatar'
    ];

    public function social()
    {
        return $this->hasOne(Social::class);
    }
}
