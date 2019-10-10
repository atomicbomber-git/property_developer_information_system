<?php

namespace App\Http\Controllers;

use App\DeliveryOrder;
use App\DeliveryOrderItem;
use App\Enums\EntityType;
use App\Item;
use App\Storage;
use App\Vendor;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class InternalDeliveryOrderController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) {
            return view("internal_delivery_order.index");
        }

        $delivery_orders = DeliveryOrder::query()
            ->select(["delivery_orders.*"])
            ->where('source_type', EntityType::STORAGE)
            ->with([
                'receiver:id,name',
                'source:id,name',
                'target:id,name'
            ])
            ->withCount(DeliveryOrder::countedRelations())
            ->orderByDesc("received_at")
            ->orderByDesc("created_at")
            ->orderByDesc("updated_at");

        $source_name_query = Vendor::query()
            ->select("name")
            ->whereColumn("vendors.id", "=", "delivery_orders.source_id")
            ->where("delivery_orders.source_type", EntityType::STORAGE)
            ->limit(1);

        $target_name_query = Storage::query()
            ->select("name")
            ->whereColumn("storages.id", "=", "delivery_orders.target_id")
            ->where("delivery_orders.target_type", EntityType::STORAGE)
            ->limit(1);

        return DataTables::eloquent($delivery_orders)
            ->smart(true)
            ->addIndexColumn()
            ->addColumn("controls", function (DeliveryOrder $delivery_order) {
                return view("internal_delivery_order.control", compact("delivery_order"));
            })
            ->filterColumn("source_name", function ($query, $keyword) use($source_name_query) {
                $query->whereRaw(
                    "LOWER(({$source_name_query->toSql()})) LIKE LOWER(?)",
                    array_merge($source_name_query->getBindings(), ["%$keyword%"])
                );
            })
            ->filterColumn("target_name", function ($query, $keyword) use($target_name_query) {
                $query->whereRaw(
                    "LOWER(({$target_name_query->toSql()})) LIKE LOWER(?)",
                    array_merge($target_name_query->getBindings(), ["%$keyword%"])
                );
            })
            ->orderColumn("source_name", "({$source_name_query->toSql()}) $1", $source_name_query->getBindings())
            ->orderColumn("target_name", "({$target_name_query->toSql()}) $1", $target_name_query->getBindings())
            ->toJson();
    }

    public function create(Request $request)
    {
        $storages = Storage::query()
            ->select(
                "id",
                "name",
                "address",
            )
            ->with([
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
            ])
            ->get();

        return view("internal_delivery_order.create", compact("storages"));
    }

    public function store(Request $request)
    {
        dump($request);

        // $request->validate([
        //     ""
        // ]);
    }
}
