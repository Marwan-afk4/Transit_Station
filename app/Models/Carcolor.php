<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carcolor extends Model
{
    use HasFactory;

    protected $fillable = [
        'color_name',
        'color_code',
    ];
}
