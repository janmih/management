<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public $guarded = ['id'];

    protected $attributes = [
        'guard_name' => 'web',
    ];
}
