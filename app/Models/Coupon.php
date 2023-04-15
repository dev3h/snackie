<?php

namespace App\Models;

use App\Enums\CouponTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'quantity',
        'type',
        'detail',
    ];

    public function getCouponTypeAttribute()
    {
        return CouponTypeEnum::getKeyByValue($this->type);
    }
    public function getCouponDetailAttribute() {
      if($this->type == 0) {
        return $this->detail . '%';
      } else {
        return number_format($this->detail) . 'đ';
      }
    }
}
