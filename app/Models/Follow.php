<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    /**
     * Name table in data base.
     *
     * @var string
     */
    protected $table = 'follows';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'by', 'status', 'created_at', 'updated_at'];

    public function userFollow()
    {
        return $this->hasMany('App\Models\User', 'id', 'user_id');
    }

    public function followUser()
    {
        return $this->hasMany('App\Models\User', 'id', 'by');
    }
}
