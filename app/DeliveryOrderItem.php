<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DeliveryOrderItem extends Model
{
    public $fillable = [
        'delivery_order_id',
        'item_id',
        'quantity',
        'price'
    ];

    public function delivery_order()
    {
        return $this->belongsTo(DeliveryOrder::class);
    }

    public function stocks()
    {
        return $this->morphMany(Stock::class, "origin");
    }

    public function stock_mutations()
    {
        return $this->morphMany(StockMutation::class, "origin");
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function getPriceAttribute($value)
    {
        return number_format($value, 0, '', '');
    }

    public function updatePrice($price)
    {
        DB::beginTransaction();

        $this->stocks()->update(["value" => $price,]);
        $this->stock_mutations()->update(["value" => $price,]);

        $this->update(compact("price"));

        DB::commit();
    }
}
