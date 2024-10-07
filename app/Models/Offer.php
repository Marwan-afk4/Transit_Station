<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable=[
        'price',
        'price_discount',
        'offer_name',
        'duration',
    ];

    public function subscription()
    {
        return $this->hasMany(Subscription::class);
    }
}
