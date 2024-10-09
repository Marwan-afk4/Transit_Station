<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable =[
        'car_id',
        'user_id',
        'location_id',
        'driver_id',
        'request_time',
        'pick_up_date',
        'return_time',
        'status',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function car(){
        return $this->belongsTo(Car::class);
    }

    public function location(){
        return $this->belongsto(Location::class);
    }

    public function parking(){
        return $this->belongsto(Parking::class);
    }
}
