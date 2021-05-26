<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    /**
     * Name of table
     *
     * @var string
     */
    protected $table = "notifications";

    /**
     * Array columns
     *
     * @var string[]
     */
    protected $fillable = [
        "type",
        "notifiable_type",
        "notifiable_id",
        "data",
        "read_at"
    ];
}
