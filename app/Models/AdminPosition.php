<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminPosition extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function role(){
        return $this->hasMany(Role::class);
    }

    public function user(){
        return $this->hasMany(User::class);
    }
}
