<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDivision extends Model
{
    /**
     * Name table in data base.
     *
     * @var string
     */
    protected $table = 'user_divisions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'division_id', 'type', 'created_at', 'updated_at'];
    //
}
