<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockMutation extends Model
{
    public function source()
    {
        return $this->morphTo();
    }

    public function target()
    {
        return $this->morphTo();
    }
}
