<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Vendor extends Model
{
    public $fillable = [
        'name', 'address', 'code'
    ];

    public function items()
    {
        return $this
            ->belongsToMany(Item::class, (new VendorItem)->getTable())
            ->using(VendorItem::class)
            ->as(Str::snake(class_basename(VendorItem::class)));
    }

    public function contact_people()
    {
        return $this->hasMany(VendorContactPerson::class);
    }

    public function delivery_orders()
    {
        return $this->morphMany(DeliveryOrder::class, 'source');
    }

    public function getNameAttribute($value)
    {
        return strtoupper($value);
    }

    public function getCodeAttribute($value)
    {
        return strtoupper($value);
    }
}
