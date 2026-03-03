<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
        'default_amount',
        'icon',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'default_amount' => 'decimal:2',
    ];
}
