<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use App\DeliveryOrder;
use App\DeliveryOrderItem;
use App\Enums\EntityType;
use App\Stock;
use App\Vendor;
use App\Storage;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Yajra\DataTables\Facades\DataTables;

class DeliveryOrderController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) {
            return view("delivery_order.index");
        }

        $delivery_orders = DeliveryOrder::query()
            ->select(["delivery_orders.*"])
            ->where('source_type', EntityType::VENDOR)
            ->with([
                'receiver:id,name',
                'source:id,name',
                'target:id,name'
            ])
            ->withCount(DeliveryOrder::countedRelations())
            ->orderByDesc("received_at")
            ->orderByDesc("created_at")
            ->orderByDesc("updated_at");

        $vendor_name_query = Vendor::query()
            ->select("name")
            ->whereColumn("vendors.id", "=", "delivery_orders.source_id")
            ->where("delivery_orders.source_type", EntityType::VENDOR)
            ->limit(1);

        $storage_name_query = Storage::query()
            ->select("name")
            ->whereColumn("storages.id", "=", "delivery_orders.target_id")
            ->where("delivery_orders.target_type", EntityType::STORAGE)
            ->limit(1);

        return DataTables::eloquent($delivery_orders)
            ->smart(true)
            ->addIndexColumn()
            ->addColumn("controls", function (DeliveryOrder $delivery_order) {
                return view("delivery_order.control", compact("delivery_order"));
            })
            ->filterColumn("source_name", function ($query, $keyword) use($vendor_name_query) {
                $query->whereRaw(
                    "LOWER(({$vendor_name_query->toSql()})) LIKE LOWER(?)",
                    array_merge($vendor_name_query->getBindings(), ["%$keyword%"])
                );
            })
            ->filterColumn("target_name", function ($query, $keyword) use($storage_name_query) {
                $query->whereRaw(
                    "LOWER(({$storage_name_query->toSql()})) LIKE LOWER(?)",
                    array_merge($storage_name_query->getBindings(), ["%$keyword%"])
                );
            })
            ->orderColumn("source_name", "({$vendor_name_query->toSql()}) $1", $vendor_name_query->getBindings())
            ->orderColumn("target_name", "({$storage_name_query->toSql()}) $1", $storage_name_query->getBindings())
            ->toJson();
    }

    public function create()
    {
        $vendors = Vendor::query()
            ->select('id', 'name')
            ->with("items:items.id,name,unit")
            ->orderBy('name')
            ->get();

        $storages = Storage::query()
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        $users = User::query()
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return view('delivery_order.create', compact('vendors', 'storages', 'users'));
    }

    public function store()
    {
        $data = $this->validate(request(), [
            "vendor_id" => "required|exists:vendors,id",
            "storage_id" => "required|exists:storages,id",
            "receiver_id" => "required|exists:users,id",
            "received_at" => "required|date",
            "items" => "required|array",
            "items.*.item_id" => "required|exists:items,id",
            "items.*.quantity" => "required|numeric|gt:0",
        ]);

        DB::transaction(function() use($data) {
            $delivery_order = DeliveryOrder::create([
                'creator_id' => Auth::user()->id,
                'source_type' => EntityType::VENDOR,
                'source_id' => $data['vendor_id'],
                'target_type' => EntityType::STORAGE,
                'target_id' => $data['storage_id'],
                'receiver_id' => $data['receiver_id'],
                'received_at' => $data['received_at']
            ]);

            foreach ($data['items'] as $item) {
                $delivery_order_item = $delivery_order
                    ->delivery_order_items()
                    ->create($item);

                Stock::create([
                    "item_id" => $item["item_id"],
                    "quantity" => $item["quantity"],
                    "value" => 0,
                    "storage_type" => EntityType::STORAGE,
                    "storage_id" => $data["storage_id"],
                    "origin_type" => EntityType::DELIVERY_ORDER_ITEM,
                    "origin_id" => $delivery_order_item->id,
                ]);
            }
        });

        session()->flash('message.success', __('messages.create.success'));
    }

    public function edit(DeliveryOrder $delivery_order)
    {
        $delivery_order->load("delivery_order_items:id,delivery_order_id,quantity,price,item_id");

        $vendors = Vendor::query()
            ->select('id', 'name')
            ->with("items:items.id,name,unit")
            ->orderBy('name')
            ->get();

        $storages = Storage::query()
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        $users = User::query()
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return view("delivery_order.edit", compact("delivery_order", "vendors", "storages", "users"));
    }

    public function update(DeliveryOrder $delivery_order)
    {
        $data = $this->validate(request(), [
            "vendor_id" => "required|exists:vendors,id",
            "storage_id" => "required|exists:storages,id",
            "receiver_id" => "required|exists:users,id",
            "received_at" => "required|date",
            "items" => "required|array",
            "items.*.item_id" => "required|exists:items,id",
            "items.*.quantity" => "required|numeric|gt:0",
        ]);

        DB::transaction(function() use($data, $delivery_order) {
            $delivery_order->update([
                'creator_id' => Auth::user()->id,
                'source_type' => EntityType::VENDOR,
                'source_id' => $data['vendor_id'],
                'target_type' => EntityType::STORAGE,
                'target_id' => $data['storage_id'],
                'receiver_id' => $data['receiver_id'],
                'received_at' => $data['received_at']
            ]);

            $delivery_order_items_data = new Collection($data["items"]);

            $delivery_order
                ->delivery_order_items()
                ->whereNotIn("item_id", $delivery_order_items_data->pluck("item_id"))
                ->delete();

            $delivery_order_items_data
                ->each(function ($delivery_order_item_data) use($delivery_order) {
                    $delivery_order
                        ->delivery_order_items()
                        ->updateOrCreate(
                            [
                                "item_id" => $delivery_order_item_data["item_id"],
                            ],
                            [
                                "quantity" => $delivery_order_item_data["quantity"],
                            ]
                        );
                });
        });

        session()->flash('message.success', __('messages.update.success'));
    }

    public function delete(DeliveryOrder $delivery_order)
    {
        DB::beginTransaction();

        $delivery_order->delivery_order_items()->delete();
        $delivery_order->delete();


        DB::commit();

        return back()
            ->with('message.success', __('messages.delete.success'));
    }

    public function createItem(DeliveryOrder $delivery_order)
    {
        $item_ids = $delivery_order->source->items->pluck('id');

        $data = $this->validate(request(), [
            'item_id' => ['required', 'integer', Rule::in($item_ids)],
            'quantity' => ['required', 'min:0']
        ]);

        $delivery_order_item = DeliveryOrderItem::where([
            'delivery_order_id' => $delivery_order->id,
            'item_id' => $data['item_id']
        ])->first();

        if (empty($delivery_order_item)) {
            $delivery_order->delivery_order_items()->create($data);
        }
        else {
            $delivery_order_item->increment('quantity', $data['quantity']);
        }

        return back()
            ->with('message.success', __('messages.create.success'));
    }

    public function updateItems(DeliveryOrder $delivery_order)
    {
        $delivery_order_item_ids = $delivery_order
            ->delivery_order_items()
            ->pluck('id');

        $validation_rules = [
            "quantities" => 'required|array'
        ];

        foreach ($delivery_order_item_ids as $id) {
            $validation_rules["quantities.$id"] = "required|min:0";
        }

        $data = $this->validate(request(), $validation_rules);

        DB::transaction(function() use($data) {
            foreach ($data['quantities'] as $id => $quantity) {
                DeliveryOrderItem::where('id', $id)
                    ->update(['quantity' => $quantity]);
            }
        });

        return back()
            ->with('message.success', __('messages.update.success'));
    }

    public function updatePrice(DeliveryOrder $delivery_order)
    {
        if (request()->ajax()) {
            $delivery_order->load([
                'delivery_order_items:id,delivery_order_id,quantity,price,item_id',
                'delivery_order_items.item:id,name,unit'
            ]);

            $item_ids = $delivery_order->delivery_order_items->pluck('item_id');

            $item_prices = DB::table('delivery_order_items')
                ->select('item_id', DB::raw('FIRST_VALUE(price) OVER(PARTITION BY item_id ORDER BY invoices.received_at DESC) AS latest_price'))
                ->whereIn('item_id', $item_ids)
                ->join('delivery_orders', 'delivery_orders.id', '=', 'delivery_order_id')
                ->join('invoices', 'invoices.id', '=', 'delivery_orders.invoice_id')
                ->whereNotNull('price')
                ->distinct()
                ->get()
                ->mapWithKeys(function($item) { return [$item->item_id => $item->latest_price]; });

            $delivery_order->delivery_order_items->transform(function ($item) use($item_prices) {
                $item->latest_price =  $item_prices[$item->item_id] ?? 0;
                return $item;
            });

            return $delivery_order->delivery_order_items;
        }

        return view('delivery_order.update_price', compact('delivery_order'));
    }

    public function processUpdatePrice(DeliveryOrder $delivery_order) {
        $data = $this->validate(request(), [
            'delivery_order_items' => 'required|array',
            'delivery_order_items.*.id' => 'required|integer',
            'delivery_order_items.*.price' => 'required|min:0'
        ]);

        DB::beginTransaction();

        foreach ($data['delivery_order_items'] as $delivery_order_item) {
            $delivery_order_item = DeliveryOrderItem::find(
                $delivery_order_item["id"]
            )
            ->updatePrice(
                $delivery_order_item['price']
            );
        }

        DB::commit();

        session()->flash('message.success', __('messages.update.success'));

        return [
            'status' => 'success',
            'redirect' => URL::previous()
        ];
    }
}
