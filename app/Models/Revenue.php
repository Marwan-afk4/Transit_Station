<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revenue extends Model
{
    use HasFactory;

    protected $fillable=[
        'type_revenue_id',
        'revenue_amount',
        'date'
    ];

    public function type_revenue(){
        return $this->belongsTo(TypeRevenue::class);
    }
}
