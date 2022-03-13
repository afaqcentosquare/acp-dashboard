<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [ 
        'name',
        'description',
        'amount',
        'sell_type',
        'county',
        'location',
        'service_provider_id',
    ];

}
