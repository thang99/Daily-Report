<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    /**
     * Name table in data base.
     *
     * @var string
     */
    protected $table = 'reports';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'title', 'content', 'assign_to', 'status', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function assignUser()
    {
        return $this->hasMany('App\Models\User', 'id', 'assign_to');
    }

    public function feedback()
    {
        return $this->hasOne('App\Models\FeedBack');
    }
}
