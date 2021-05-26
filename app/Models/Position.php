<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    /**
     * Name table in data base.
     *
     * @var string
     */
    protected $table = 'positions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'name', 'status', 'created_at', 'updated_at'];
    
    public function divisions()
    {
        return $this->belongsToMany('App\Models\Division');
    }
}
