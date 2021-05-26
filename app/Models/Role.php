<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * Name table in data base.
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'name', 'guard_name','created_at', 'updated_at'];

    // public function users() 
    // {
    //     return $this->belongsToMany('App\Models\User','model_has_roles','model_id','role_id');
    // }
}
