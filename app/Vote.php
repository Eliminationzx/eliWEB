<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = [
        'url', 'log_url1', 'log_url2', 'log_url2', 'log_url2', 'log_url3', 'log_url4', 'log_url5','img', 'name', 'descr', 'reward', 'inputs', 'status', 'clickable_only', 'hostname',
    ];
}
