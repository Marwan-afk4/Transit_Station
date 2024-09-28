<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable=[
        'pick_up_address',
        'location_image',
        'address',
        'address_in_detail',
    ];

    public function request(){
        return $this->hasMany(Request::class);
    }
}
