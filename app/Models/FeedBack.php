<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedBack extends Model
{
    protected $table = 'feedback_reports';

    protected $fillable = [
        'from','to','message','report_id','created_at','updated_at'
    ];
}
