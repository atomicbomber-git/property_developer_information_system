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

class DeliveryOrderController extends Controller
{
    public function index()
    {
        $delivery_orders = DeliveryOrder::query()
            ->select('id', 'receiver_id', 'received_at', 'source_type', 'source_id', 'target_type', 'target_id')
            ->where('source_type', 'VENDOR')
            ->with(['receiver:id,name', 'source:id,name', 'target:id,name'])
            ->withCount('delivery_order_items')
            ->orderBy('created_at', 'desc')
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
            'target_id' => ['required', Rule::in($storage_ids)],
            'receiver_id' => ['required', Rule::in($user_ids)],
            'received_at' => ['required', 'date']
        ]);

        $data = $first_validator->validate();

        $vendor_item_ids = Vendor::find($data['source_id'])
            ->items()
            ->select('id')
            ->pluck('id');

        $second_validator = Validator::make(request()->all(), [
            'delivery_items' => ['required', 'array'],
            'delivery_items.*.id' => ['required', Rule::in($vendor_item_ids)],
            'delivery_items.*.quantity' => ['required', 'integer', 'min:1']
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

        return redirect()
            ->route('delivery_order.index')
            ->with('message.success', __('messages.create.success'));
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
            'quantity' => ['required', 'integer', 'min:1']
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
            $validation_rules["quantities.$id"] = "required|integer|min:1";
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
}
