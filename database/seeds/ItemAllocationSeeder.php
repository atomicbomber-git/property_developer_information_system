<?php

use Illuminate\Database\Seeder;
use App\InvoiceItem;
use App\ItemAllocation;
use App\Storage;

class ItemAllocationSeeder extends Seeder
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
                ItemAllocation::create([
                    'source_id' => $invoice_item_id,
                    'source_type' => 'INVOICE',
                    'target_id' => $storage_id,
                    'target_type' => 'STORAGE',
                    'quantity' => 4
                ]);
            }
        }
    }
}
