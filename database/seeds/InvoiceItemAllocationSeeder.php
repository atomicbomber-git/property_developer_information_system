<?php

use Illuminate\Database\Seeder;
use App\InvoiceItem;
use App\InvoiceItemAllocation;
use App\Storage;

class InvoiceItemAllocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $invoice_item_ids = InvoiceItem::query()
            ->select('id')
            ->pluck('id');

        $storage_ids = Storage::query()
            ->select('id')
            ->pluck('id');

        foreach ($invoice_item_ids as $invoice_item_id) {
            foreach ($storage_ids as $storage_id) {
                InvoiceItemAllocation::create([
                    'invoice_item_id' => $invoice_item_id,
                    'storage_id' => $storage_id,
                    'quantity' => 4
                ]);
            }
        }
    }
}
