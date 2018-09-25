<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\DeliveryOrder;
use App\DeliveryOrderItem;
use App\Vendor;
use App\Storage;
use App\User;
use Validator;
use DB;
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
            ->paginate(10);

        return view('delivery_order.index', compact('delivery_orders'));
    }

    public function create()
    {
        $vendors = Vendor::query()
            ->select('id', 'name')
            ->get();

        $storages = Storage::query()
            ->select('id', 'name')
            ->get();

        $users = User::query()
            ->select('id', 'name')
            ->get();

        return view('delivery_order.create', compact('vendors', 'storages', 'users'));
    }

    public function processCreate()
    {
        $vendor_ids = Vendor::select('id')->pluck('id');
        $storage_ids = Storage::select('id')->pluck('id');
        $user_ids = User::select('id')->pluck('id');

        $first_validator = Validator::make(request()->all(), [
            'source_id' => ['required', Rule::in($vendor_ids)],
        ]);

        $data = $first_validator->validate();

        $vendor_item_ids = Vendor::find($data['source_id'])
            ->items()
            ->select('id')
            ->pluck('id');

        $second_validator = Validator::make(request()->all(), [
            'target_id' => ['required', Rule::in($storage_ids)],
            'receiver_id' => ['required', Rule::in($user_ids)],
            'received_at' => ['required', 'date'],
            'delivery_items' => ['required', 'array'],
            'delivery_items.*.id' => ['required', Rule::in($vendor_item_ids)],
            'delivery_items.*.quantity' => ['required', 'min:0']
        ]);

        $data = array_merge($data, $second_validator->validate());
        
        DB::transaction(function() use($data) {
            $delivery_order = DeliveryOrder::create([
                'creator_id' => auth()->user()->id,
                'source_type' => 'VENDOR',
                'source_id' => $data['source_id'],
                'target_type' => 'STORAGE',
                'target_id' => $data['target_id'],
                'receiver_id' => $data['receiver_id'],
                'received_at' => $data['received_at']
            ]);

            foreach ($data['delivery_items'] as $delivery_item) {
                DeliveryOrderItem::create([
                    'delivery_order_id' => $delivery_order->id,
                    'item_id' => $delivery_item['id'],
                    'quantity' => $delivery_item['quantity']
                ]);
            }
        });

        session()->flash('message.success', __('messages.create.success'));
        
        return [
            'status' => 'success',
            'redirect' => route('delivery_order.index')
        ];
    }

    public function update(DeliveryOrder $delivery_order)
    {
        $vendors = Vendor::query()
            ->select('id', 'name')
            ->get();

        $storages = Storage::query()
            ->select('id', 'name')
            ->get();

        $users = User::query()
            ->select('id', 'name')
            ->get();

        return view('delivery_order.update', compact('delivery_order', 'vendors', 'storages', 'users'));
    }

    public function processUpdate(DeliveryOrder $delivery_order)
    {
        $vendor_ids = Vendor::query()
            ->select('id')
            ->pluck('id');

        $storage_ids = Storage::query()
            ->select('id')
            ->pluck('id');

        $user_ids = User::query()
            ->select('id')
            ->pluck('id');

        $data = $this->validate(request(), [
            'source_id' => ['required', Rule::in($vendor_ids)],
            'target_id' => ['required', Rule::in($storage_ids)],
            'receiver_id' => ['required', Rule::in($user_ids)],
            'received_at' => ['required', 'date']
        ]);

        $delivery_order->update([
            'source_type' => 'VENDOR',
            'source_id' => $data['source_id'],
            'target_type' => 'STORAGE',
            'target_id' => $data['target_id'],
            'receiver_id' => $data['receiver_id'],
            'received_at' => $data['received_at']
        ]);

        return redirect()
            ->route('delivery_order.index')
            ->with('message.success', __('messages.update.success'));
    }

    public function delete(DeliveryOrder $delivery_order)
    {
        $delivery_order->delete();

        return back()
            ->with('message.success', __('messages.delete.success'));
    }

    public function detail(DeliveryOrder $delivery_order)
    {
        $delivery_order->load([
            'source',
            'target',
            'source.items:id,name,vendor_id,category_id',
            'source.items.category:id,name',
            'delivery_order_items:id,delivery_order_id,item_id,quantity',
            'delivery_order_items.item:id,name,unit'
        ]);
        
        return view('delivery_order.detail', compact('delivery_order'));
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

    public function deleteItem(DeliveryOrder $delivery_order, DeliveryOrderItem $delivery_order_item)
    {
        $delivery_order_item->delete();

        return back()
            ->with('message.success', __('messages.delete.success'));
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

        return view('delivery_order.update_price', compact('delivery_order', 'item_prices'));
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
