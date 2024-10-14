<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parking extends Model
{
    use HasFactory;

    protected $fillable =[
        'name',
        'capacity',
        'location'
    ];

    public function car(){
        return $this->belongsToMany(Car::class,'car_parking');
    }

    public function request(){
        return $this->hasmany(Request::class);
    }

    public function drivers(){
        return $this->hasmany(Driver::class);
    }

    public function locations()  // plural naming
{
    return $this->hasMany(Location::class);
}
}
