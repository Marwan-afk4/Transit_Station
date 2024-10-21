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
        'carcolor_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function request(){
        return $this->hasmany(Request::class);
    }

    public function parking(){
        return $this->belongsToMany(Parking::class,'car_parking');
    }

    public function carcolor(){
        return $this->belongsTo(Carcolor::class);
    }
}
