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
        'request_time',
        'pick_up_date'
    ];

}
