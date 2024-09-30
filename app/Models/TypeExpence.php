<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeExpence extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_name'
    ];

    public function expence()
    {
        return $this->hasMany(Expence::class);
    }
}
