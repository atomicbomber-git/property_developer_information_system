<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockAdjustment extends Model
{
    public $guarded = [

    ];

    public function stocks()
    {
        return $this->morphMany(Stock::class, "storage");
    }
}
