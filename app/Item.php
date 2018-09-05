<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public $fillable = [
        'category_id',
        'vendor_id',
        'name',
        'unit'
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function delivery_order_items()
    {
        return $this->hasMany(DeliveryOrderItem::class);
    }

    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }
}
