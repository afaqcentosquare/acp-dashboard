<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [ 
        'name',
        'description',
        'sub_group_id',
    ];

    public function sub_group(){
        return $this->belongsTo('App\SubGroup');
    }
}
