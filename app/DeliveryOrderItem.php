<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
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

    public function scopeWithLatestPrice(Builder $query)
    {
        $parentTableAlias = $this->getTable();
        $subTableAlias = "reference_delivery_order_items";

        $query->addSelect([
            "latest_price" =>
                DeliveryOrderItem::from("delivery_order_items AS {$subTableAlias}")
                    ->select("price")
                    ->whereColumn("{$subTableAlias}.item_id", "{$parentTableAlias}.item_id")
                    ->whereNotNull("price")
                    ->belongsToExternalDeliveryOrder()
                    ->orderByLatestSentDeliveryOrder()
                    ->limit(1)
        ]);
    }

    public function scopeBelongsToExternalDeliveryOrder(Builder $query)
    {
        $query->whereHas("delivery_order", function (Builder $query) {
            $query->whereHasMorph("source", [Vendor::class]);
        });
    }

    public function scopeOrderByLatestSentDeliveryOrder(Builder $query)
    {
        $query->orderByDesc(
            DeliveryOrder::query()
                ->select("sent_at")
                ->whereColumn("delivery_order_id", "delivery_order_items.id")
                ->limit(1)
        );
    }
}
