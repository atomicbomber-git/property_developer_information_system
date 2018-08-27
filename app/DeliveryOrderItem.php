<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryOrderItem extends Model
{
    public $fillable = [
        'delivery_order_id',
        'item_id',
        'quantity'
    ];

    public function delivery_order()
    {
        return $this->belongsTo(DeliveryOrder::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
