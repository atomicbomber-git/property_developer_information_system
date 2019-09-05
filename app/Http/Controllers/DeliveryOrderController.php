<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use App\DeliveryOrder;
use App\DeliveryOrderItem;
use App\Enums\EntityType;
use App\Vendor;
use App\Storage;
use App\User;
use DB;
use Illuminate\Support\Facades\Auth;
use URL;

class DeliveryOrderController extends Controller
{
    public function index()
    {
        $delivery_orders = DeliveryOrder::query()
            ->select('id', 'receiver_id', 'received_at', 'source_type', 'source_id', 'target_type', 'target_id')
            ->where('source_type', 'VENDOR')
            ->with(['receiver:id,name', 'source:id,name', 'target:id,name'])
            ->withCount('delivery_order_items')
            ->orderBy('received_at', 'desc')
            ->paginate();

        return view('delivery_order.index', compact('delivery_orders'));
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
                $delivery_order->delivery_order_items()
                    ->create($item);
            }
        });

        session()->flash('message.success', __('messages.create.success'));
    }

    public function edit(DeliveryOrder $delivery_order)
    {
        $delivery_order->load("delivery_order_items:id,quantity,price");

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
    }

    public function delete(DeliveryOrder $delivery_order)
    {
        $delivery_order->delete();

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
            DeliveryOrderItem::where(['id' => $delivery_order_item['id'] ])
                ->update(['price' => $delivery_order_item['price'] ]);
        }

        DB::commit();

        session()->flash('message.success', __('messages.update.success'));

        return [
            'status' => 'success',
            'redirect' => URL::previous()
        ];
    }
}
