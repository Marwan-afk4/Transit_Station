<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'role_name',
        'admin_position_id'
    ];

    public function adminPosition()
    {
        return $this->belongsTo(AdminPosition::class);
    }
}
