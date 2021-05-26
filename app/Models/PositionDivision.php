<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PositionDivision extends Model
{
     /**
     * Name table in data base.
     *
     * @var string
     */
    protected $table = 'position_division';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['division_id', 'position_id', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->hasOne('App\Models\User');
    }
}
