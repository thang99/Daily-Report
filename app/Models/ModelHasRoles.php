<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelHasRoles extends Model
{
    /**
     * Name table in data base.
     *
     * @var string
     */
    protected $table = 'model_has_roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['role_id', 'model_type', 'model_id','created_at', 'updated_at'];
}
