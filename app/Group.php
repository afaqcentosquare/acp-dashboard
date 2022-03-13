<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [ 
        'name',
        'description',
    ];

    public function sub_groups(){
        return $this->hasMany('App\SubGroup');
    }
}
