<?php

namespace App;

use App\Traits\CanCountRelatedModels;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Item extends Model
{
    use CanCountRelatedModels;

    public $fillable = [
        'category_id',
        'vendor_id',
        'name',
        'unit',
        'note'
    ];

    public static function countedRelations()
    {
        return [
            "delivery_order_items",
            "stock_mutations",
            "stocks",
        ];
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function stock_mutations()
    {
        return $this->hasMany(StockMutation::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function vendors()
    {
        return $this->belongsToMany(Vendor::class, (new VendorItem)->getTable())
            ->using(VendorItem::class)
            ->as("vendor_item")
            ->withTimestamps();
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
