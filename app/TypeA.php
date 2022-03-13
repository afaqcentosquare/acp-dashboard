<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Sagalbot\Encryptable\Encryptable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class TypeA extends Model
{
    use SoftDeletes,Encryptable,Sortable;
    
    protected $fillable = [
        'name',
        'units',
        'cost',
        'holiday',
        'deposit',
        'installment_amount',
        'payment_frequency',
        'payment_method',
        'status',
        'asset_provider_id',
    ];

    public $sortable = [
        'name',
        'units',
        'cost',
        'holiday',
        'duration',
        'installment_amount',
        'payment_frequency',
        'payment_method',
        'status',
    ];

    protected $encryptable = [ 
        // 'payment_frequency',
        // 'payment_method',
    ];

    public function provider(){
        return $this->belongsTo('App\AssetProvider', 'asset_provider_id');
    }
    public function assets(){
        return $this->hasMany('App\Asset', 'type_a_id');
    }
}