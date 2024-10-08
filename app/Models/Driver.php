<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

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
    ];


    public function complaint(){
        return $this->hasMany(Complaint::class);
    }
}
