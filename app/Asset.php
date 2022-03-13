<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use SoftDeletes;
    
    protected $fillable = [ 
        'units',
        'cost',
        'holiday',
        'deposit',
        'installment_amount',
        'payment_frequency',
        'payment_method',
        'type_a_id',
        'category_id',
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function type_a(){
        return $this->belongsTo('App\TypeA');
    }
    public function category(){
        return $this->belongsTo('App\Category');
    }

    public function requests(){
        return $this->hasMany('App\AssetRequest');
    }

    public function payments(){
        return $this->hasMany('App\Payments');
    }

}

/**
 * Asset type 
 * holiday provision
 * deposit amount
 * payment duration
 * installment amount
 * payment frequency
 * payment method
 * 
 * Type A
 * nyayomat ++ ap
 * 
 * Type B 
 * 
 * Nyayomat ++ Merchant
 * 
 * 
 * 
 */
