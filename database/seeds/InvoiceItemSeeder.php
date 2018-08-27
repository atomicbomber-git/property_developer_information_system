<?php

use Illuminate\Database\Seeder;
use App\DeliveryOrder;
use App\InvoiceItem;
use App\Vendor;

class InvoiceItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $delivery_orders = DeliveryOrder::select('id', 'vendor_id')
            ->with('vendor:id', 'vendor.items:id,vendor_id')
            ->get();

        foreach ($delivery_orders as $delivery_order) {
            foreach ($delivery_order->vendor->items as $item) {

                factory(\App\InvoiceItem::class)->create([
                    'price' => null,
                    'invoice_id' => $delivery_order->id,
                    'item_id' => $item->id,
                ]);

            }
        }
    }
}
