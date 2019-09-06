<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public $fillable = [
        'category_id',
        'vendor_id',
        'name',
        'unit',
        'note'
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function vendors()
    {
        return $this->belongsToMany(Vendor::class, (new VendorItem)->getTable())
            ->using(VendorItem::class)
            ->as("vendor_item");
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function delivery_order_items()
    {
        return $this->hasMany(DeliveryOrderItem::class);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtoupper($value);
    }

    public function setUnitAttribute($value)
    {
        $this->attributes['unit'] = strtoupper($value);
    }
}
