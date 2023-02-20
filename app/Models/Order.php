<?php

namespace App\Models;

use App\Enums\OrderStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'shipping_id',
        'payment_id',
        'total_price',
        'status'
    ];

     public function getStatusNameAttribute()
    {
        return OrderStatusEnum::getKeyByValue($this->status);
    }
}
