<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'license_plate',
        'customer_mobile',
        'customer_name',
        'note',
        'service_type',
        'amount',
        'payment_method',
    ];
}
