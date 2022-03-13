<?php

namespace App;

use Sagalbot\Encryptable\Encryptable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Application extends Model
{
    use SoftDeletes,Encryptable,Sortable;
    
    protected $fillable = [ 
        'name',
        'shop_name',
        'county',
        'sub_county',
        'location',
        'phone',
        'email',
    ];

    public $sortable = [
        'name',
        'shop_name',
        'county',
        'sub_county',
        'location',
        'created_at',
    ];

    protected $encryptable = [ 
        'name',
        'county',
        'sub_county',
        'location',
        'email',
    ];

}
