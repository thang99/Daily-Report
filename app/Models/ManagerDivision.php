<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManagerDivision extends Model
{
     /**
     * Name table in data base.
     *
     * @var string
     */
    protected $table = 'manager_division';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['division_id', 'user_id', 'created_at', 'updated_at'];
}
