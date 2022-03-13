<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubGroup extends Model
{
    protected $fillable = [ 
        'name',
        'description',
        'group_id',
    ];

    public function group(){
        return $this->belongsTo('App\Group');
    }

    public function categories(){
        return $this->hasMany('App\Category');
    }
}
