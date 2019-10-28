<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Stock extends Model
{
    protected $fillable = [
        "item_id",
        "quantity",
        "value",
        "storage_id",
        "storage_type",
        "origin_id",
        "origin_type",
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function storage()
    {
        return $this->morphTo();
    }

    public function origin()
    {
        return $this->morphTo();
    }

    public function moveTo(Model $target, $quantity, Model $source)
    {
        if (!method_exists($target, "stocks")) {
            throw new \Exception("Target model has to have a stocks() method.");
        }

        /* Replicates this stock except for the quantity */
        $new_stock = $this->replicate(["quantity"]);
        $new_stock->quantity = $quantity;

        $this->decrementQuantity($quantity);

        $stock_transaction = StockTransaction::create();

        $stock_transaction
            ->stock_mutations()
            ->saveMany([
                /* The credit side of the transaction */
                (new StockMutation([
                    "item_id" => $this->item_id,
                    "quantity" => $quantity !== null ? -$quantity : null,
                    "value" => $this->value !== null ? -$this->value : null,
                ]))
                ->storage()->associate($this->storage)
                ->origin()->associate($this->origin),

                /* The debit side of the transaction */
                (new StockMutation([
                    "item_id" => $this->item_id,
                    "quantity" => $quantity !== null ? $quantity : null,
                    "value" => $this->value !== null ? -$this->value : null,
                ]))
                ->storage()->associate($target)
                ->origin()->associate($this->origin),
            ]);

        $stock_transaction->source()
            ->associate($source)
            ->save();

        /* Tries to find a similar stock in the target */
        $similar_stock = $target->stocks()
            ->where([
                "origin_type" => $new_stock->origin_type,
                "origin_id" => $new_stock->origin_id,
                "item_id" => $new_stock->item_id,
            ])
            ->first();

        if ($similar_stock) {
            $similar_stock->increment("quantity", $new_stock->quantity);
        }
        else {
            $target->stocks()->save($new_stock);
        }
    }

    public function decrementQuantity($quantity)
    {
        $new_quantity = $this->quantity - $quantity;

        if ($new_quantity > 0) {
            $this->update([
                "quantity" => $new_quantity,
            ]);
        }
        else if ($new_quantity == 0) {
            $this->delete();
        }
        else {
            throw new \Exception("Can't decrement more quantity than the amount recorded.");
        }
    }
}
