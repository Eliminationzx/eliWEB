<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['id', 'key', 'value', 'created_at', 'updated_at'];
    protected $table = 'settings';
}
