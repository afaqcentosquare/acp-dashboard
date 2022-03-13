<?php

namespace App;

use Sagalbot\Encryptable\Encryptable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class AssetProvider extends Model
{
    use SoftDeletes,Encryptable,Sortable;
    
    protected $fillable = [ 
        'name',
        'county',
        'sub_county',
        'location',
        'phone',
        'email',
        'user_id',
    ];

    public $sortable = [
        'name',
        'county',
        'sub_county',
        'location',
        'created_at',
    ];

    protected $encryptable = [ 
        'county',
        'sub_county',
        'location',
        'email',
    ];

    public function getRouteKeyName(){
        return 'name';
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function assets(){
        return $this->hasMany('App\TypeA');
    }

}
