<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable =[
        'user_id',
        'car_number',
        'car_name',
        'car_image',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function request(){
        return $this->hasmany(Request::class);
    }
}
