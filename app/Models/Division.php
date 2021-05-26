<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    /**
     * Name table in data base.
     *
     * @var string
     */
    protected $table = 'divisions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'status', 'description', 'created_at', 'updated_at'];

    public function positions()
    {
        return $this->belongsToMany('App\Models\Position');
    }
}
