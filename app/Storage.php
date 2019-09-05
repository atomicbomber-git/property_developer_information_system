<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    public $fillable = [
        'name',
        'address'
    ];

    public function stocks()
    {
        return $this->morphMany(Stock::class, "storage");
    }

    public function inbound_delivery_orders()
    {
        return $this->morphMany(DeliveryOrder::class, 'target');
    }

    public function outbound_delivery_orders()
    {
        return $this->morphMany(DeliveryOrder::class, 'source');
    }
}
