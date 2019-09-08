<?php

namespace App;

use App\Traits\HasRelatedModels;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasRelatedModels;

    public $fillable = [
        'category_id',
        'vendor_id',
        'name',
        'unit',
        'note'
    ];

    public function countedRelations()
    {
        return ["delivery_order_items"];
    }

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

    public function latest_delivery_order_item()
    {
        return $this->belongsTo(DeliveryOrderItem::class, "latest_delivery_order_item_id");
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
