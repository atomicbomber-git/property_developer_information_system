<?php

use Illuminate\Database\Seeder;
use App\Invoice;
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
        $invoices = Invoice::select('id', 'vendor_id')
            ->with('vendor:id', 'vendor.items:id,vendor_id')
            ->get();

        foreach ($invoices as $invoice) {
            foreach ($invoice->vendor->items as $item) {

                factory(\App\InvoiceItem::class)->create([
                    'price' => null,
                    'invoice_id' => $invoice->id,
                    'item_id' => $item->id,
                ]);

            }
        }
    }
}
