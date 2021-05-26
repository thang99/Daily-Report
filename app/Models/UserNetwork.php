<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserNetwork extends Model
{
    /**
     * Name table in data base.
     *
     * @var string
     */
    protected $table = 'user_networks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'provider_id', 'provider_name', 'created_at', 'updated_at'];
}
