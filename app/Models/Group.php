<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_acp_groups';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;


    public function subGroup()
    {
        return $this->hasMany(SubGroup::class, 'group_id', 'id');
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'group_id', 'id');
    }
}
