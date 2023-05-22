<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider_user_id',
        'provider',
        'customer_id',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
