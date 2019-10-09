<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockMutation extends Model
{
    public $guarded = [

    ];

    public function storage()
    {
        return $this->morphTo();
    }

    public function origin()
    {
        return $this->morphTo();
    }
}
