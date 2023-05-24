<?php

namespace App\Models;

use App\Enums\AdminRoleEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $fillable = [
        'username',
        'displayname',
        'role',
        'email',
        'password',
        'status',
        'phone'
    ];

    public function getRoleNameAttribute()
    {
        return AdminRoleEnum::getKeyByValue($this->role);
    }
}
