<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'image',
        'admin_position_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function cars(){
        return $this->hasMany(Car::class);
    }

    public function request(){
        return $this->hasMany(Request::class);
    }

    public function subscription(){
        return $this->hasMany(Subscription::class);
    }

    public function complaint(){
        return $this->hasMany(Complaint::class);
    }

    public function admin_position(){
        return $this->belongsTo(AdminPosition::class);
    }
}
