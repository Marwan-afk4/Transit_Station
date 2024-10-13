<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Driver extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable =[
        'parking_id',
        'name',
        'email',
        'phone',
        'password',
        'image',
        'salary',
        'pick_up_location',
        'cars_per_mounth',
        'location_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function complaint(){
        return $this->hasMany(Complaint::class);
    }

    public function location(){
        return $this->belongsTo(Location::class);
    }

    public function parking(){
        return $this->belongsTo(Parking::class);
    }
}
