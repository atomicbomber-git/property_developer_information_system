<?php

namespace App\Http\Controllers;

use App\DeliveryOrder;
use App\DeliveryOrderItem;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliveryOrderPriceController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function edit(DeliveryOrder $delivery_order)
    {
        $delivery_order
            ->load([
                "delivery_order_items" => function (HasMany $query) {
                    $query->withLatestPrice();
                },
                "delivery_order_items.item:id,name,unit",
            ]);

        return view("delivery_order_price.edit", compact("delivery_order"));
    }

    public function update(Request $request, DeliveryOrder $deliveryOrder)
    {
        $data = $this->validate($request, [
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
    }
}
