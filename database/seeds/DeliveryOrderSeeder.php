<?php

use Illuminate\Database\Seeder;
use App\Vendor;
use App\Storage;
use App\User;
use App\DeliveryOrder;

class DeliveryOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_ids = User::select('id')
            ->pluck('id');

        $vendor_ids = Vendor::query()
            ->limit(3)
            ->select('id')
            ->pluck('id');

        $storage_ids = Storage::select('id')
            ->pluck('id');

        foreach ($vendor_ids as $vendor_id) {
            $this->createVendorDeliveryOrder($vendor_id, $storage_ids->random(), $user_ids->random());
            $this->createVendorDeliveryOrder($vendor_id, $storage_ids->random(), $user_ids->random());
        }
    }

    private function createVendorDeliveryOrder($vendor_id, $storage_id, $receiver_id)
    {
        DeliveryOrder::create([
            'receiver_id' => $receiver_id,
            'source_id' => $vendor_id,
            'source_type' => 'VENDOR',
            'target_id' => $storage_id,
            'target_type' => 'STORAGE',
            'received_at' => now()
        ]);
    }
}
