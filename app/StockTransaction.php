<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockTransaction extends Model
{
    public function stock_mutations()
    {
        return $this->hasMany(StockMutation::class);
    }
}
