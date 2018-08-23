<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    public $fillable = [
        'name',
        'address'
    ];
}
