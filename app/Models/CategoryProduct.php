<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status'
    ];

    public function getCategoryProductStatusAttribute($each)
    {
        if($this->status == 1) {
            return "<a href='{{route('category_product.inactive', $each)}}' class='btn btn-success'><span class='fa fa-eye'></span></a>";
        } else {
            return "<a href='{{route('category_product.active', $each)}}' class='btn btn-success'><span class='fa fa-eye'></span></a>";
        }
    }
}
