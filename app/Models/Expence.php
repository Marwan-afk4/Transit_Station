<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expence extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_expence_id',
        'expence_amount',
        'date'
    ];

    public function type_expence()
    {
        return $this->belongsTo(TypeExpence::class);
    }
}
