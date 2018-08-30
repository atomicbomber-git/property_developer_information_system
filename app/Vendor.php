<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    public $fillable = [
        'name',
        'address'
    ];

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function contact_people()
    {
        return $this->hasMany(VendorContactPerson::class);
    }

    public function delivery_orders()
    {
        return $this->morphMany(DeliveryOrder::class, 'source');
    }
}
