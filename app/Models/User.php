<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    protected $table = 'users';

    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'position_division_id',
        'name',
        'email',
        'avatar',
        'password',
        'phone',
        'birthday',
        'status',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        // 'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function positions()
    {
        $this->hasOne('App\Models\Position', 'position_id', 'id');
    }

    public function reports()
    {
        return $this->hasMany('App\Models\Report');
    } 

    public function division_position()
    {
        return $this->belongsTo('App\Models\PositionDivision');
    }

    // public function roles() 
    // {
    //     return $this->belongsToMany('App\Models\Role','model_has_roles','model_id','role_id');
    // }
}
