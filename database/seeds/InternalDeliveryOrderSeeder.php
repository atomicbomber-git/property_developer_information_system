<?php

use Illuminate\Database\Seeder;
use App\DeliveryOrder;
use App\DeliveryOrderItem;
use App\Storage;
use Illuminate\Support\Facades\DB;

class InternalDeliveryOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $delivery_orders = DeliveryOrder::select('id', 'target_id', 'target_type')
            ->where('source_type', 'VENDOR')
            ->where('target_type', 'STORAGE')
            ->with('delivery_order_items:delivery_order_id,item_id,quantity')
            ->get();

        DB::transaction(function() use($delivery_orders) {
            $target_storage = Storage::create([
                'name' => 'Dumpster',
                'address' => 'Dump Avenue'
            ]);

            foreach ($delivery_orders as $delivery_order) {
                $out_delivery_order = DeliveryOrder::create([
                    'source_type' => 'STORAGE',
                    'source_id' => $delivery_order->target_id,
                    'target_type' => 'STORAGE',
                    'target_id' => $target_storage->id,
                    'received_at' => now()
                ]);
    
                foreach ($delivery_order->delivery_order_items as $delivery_order_item) {
                    
                    $out_quantity = rand(1, 20);
    
                    if ($delivery_order_item->quantity < $out_quantity)
                        continue;
    
                    DeliveryOrderItem::create([
                        'delivery_order_id' => $out_delivery_order->id,
                        'item_id' => $delivery_order_item->item_id,
                        'quantity' => $delivery_order_item->quantity - $out_quantity
                    ]);
                }
            }
        });
    }
}
