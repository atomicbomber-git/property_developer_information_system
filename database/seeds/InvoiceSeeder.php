<?php

use Illuminate\Database\Seeder;
use App\Invoice;
use App\DeliveryOrder;
use Illuminate\Support\Facades\DB;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $delivery_order_groups = DeliveryOrder::select('id', 'source_id')
            ->where('source_type', 'VENDOR')
            ->get()
            ->groupBy('source_id');

        foreach ($delivery_order_groups as $delivery_orders) {
            foreach ($delivery_orders->chunk(10) as $delivery_order_chunk) {
                DB::transaction(function() use($delivery_order_chunk) {
                    
                    $invoice = Invoice::create([
                        'received_at' => now()
                    ]);

                    foreach ($delivery_order_chunk as $delivery_order) {
                        $delivery_order->update(['invoice_id' => $invoice->id]);
                    }
                });
            }
        }
    }
}
