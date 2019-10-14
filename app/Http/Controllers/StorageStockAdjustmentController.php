<?php

namespace App\Http\Controllers;

use App\DeliveryOrderItem;
use App\Item;
use App\Stock;
use App\StockAdjustment;
use App\Storage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class StorageStockAdjustmentController extends Controller
{
    public function create(Request $request, Storage $storage)
    {
        $items = Item::query()
            ->select(
                "id",
                "name",
                "unit",
            )
            ->orderBy("name")
            ->get();

        $storage->load([
            "stocks" => function (MorphMany $query) {
                $query->select(
                    "id",
                    "item_id",
                    "storage_id",
                    "storage_type",
                    "origin_id",
                    "origin_type",
                    "quantity",
                    "value",
                )
                ->orderBy(
                    Item::query()
                        ->select("name")
                        ->whereColumn("id", "stocks.item_id")
                );
            },
            "stocks.item" => function (BelongsTo $query) {
                $query->select(
                    "id",
                    "name",
                    "unit",
                );
            },
            "stocks.origin" => function (MorphTo $query) {
                $query->morphWith([
                    DeliveryOrderItem::class => [
                        "delivery_order:id,source_id,source_type",
                        "delivery_order.source",
                    ],
                ]);
            },
        ]);

        return view("storage_stock_adjustment.create", compact("storage", "items"));
    }

    public function store(Request $request, Storage $storage)
    {
        $data = $request->validate([
            "new_stocks.*.item_id" => "required",
            "new_stocks.*.value" => "nullable",
            "new_stocks.*.quantity" => "required",
            "old_stocks.*.id" => "required",
            "old_stocks.*.quantity" => "required",
        ]);

        DB::transaction(function () use($data, $storage) {

            $stock_adjustment = StockAdjustment::create([
                "storage_id" => $storage->id,
            ]);

            $old_stocks = (new Collection($data["old_stocks"] ?? []))
                ->keyBy("id");

            $stocks = $storage->stocks()
                ->select(
                    "id",
                    "quantity",
                    "item_id",
                    "storage_id",
                    "storage_type",
                    "origin_id",
                    "origin_type",
                )
                ->get();

            $stocks = $stocks
                ->map(function (Stock $stock) use($old_stocks) {
                    $stock->difference =
                        $old_stocks[$stock->id]["quantity"] -
                        $stock->quantity;

                    return $stock;
                })
                ->filter(function (Stock $stock) {
                    return $stock->difference != 0;
                });

            list($inbound, $outbound) = $stocks
                ->partition(function (Stock $stock) {
                    return $stock->difference > 0;
                });

            foreach ($inbound as $stock) {
                $new_stock = $stock->replicate(["storage_id", "storage_type", "quantity", "difference"]);
                $new_stock->quantity = $stock->difference;
                $new_stock->storage()->associate($stock_adjustment);
                $new_stock->moveTo($storage, $stock->difference, $stock_adjustment);
            }

            foreach ($outbound as $stock) {
                $difference = $stock->difference;
                unset($stock->difference);
                $stock->moveTo($stock_adjustment, abs($difference), $stock_adjustment);
            }

            if (!isset($data["new_stocks"])) {
                return;
            }

            $new_stocks = (new Collection($data["new_stocks"] ?? []))
                ->keyBy("id");

            foreach ($new_stocks as $new_stock) {
                (new Stock([
                    "item_id" => $new_stock["item_id"],
                    "quantity" => $new_stock["quantity"],
                    "value" => $new_stock["value"],
                ]))
                ->storage()->associate($stock_adjustment)
                ->origin()->associate($stock_adjustment)
                ->moveTo($storage, $new_stock["quantity"], $stock_adjustment);
            }

        });

        session()->flash('message.success', __('messages.update.success'));
    }
}
