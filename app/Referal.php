<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Referal extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'referalid', 'userid', 'userid_vanilla', 'userid_wotlk', 'userid_legion', 'userid_mop', 'payment',
    ];
}
