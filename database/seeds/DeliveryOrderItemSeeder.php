<?php

use Illuminate\Database\Seeder;
use App\DeliveryOrder;
use App\DeliveryOrderItem;

class DeliveryOrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $delivery_orders = DeliveryOrder::query()
            ->select('id', 'source_id', 'source_type')
            ->with(['source', 'source.items:id,name,vendor_id,category_id'])
            ->get();
        
        foreach ($delivery_orders as $delivery_order) {
            foreach ($delivery_order->source->items as $item) {
                factory(DeliveryOrderItem::class)->create([
                    'delivery_order_id' => $delivery_order->id,
                    'item_id' => $item->id,
                    'price' => rand(1, 20) * 10000
                ]);
            }
        }
    }
}
