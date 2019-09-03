<?php

use Illuminate\Database\Seeder;
use App\Vendor;
use App\Storage;
use App\User;
use App\DeliveryOrder;

class DeliveryOrderSeeder extends Seeder
{
    const DELIVERY_ORDER_COUNT_PER_MONTH = 20;
    const VENDOR_COUNT = 20;
    const MONTH_COUNT = 20;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function() {
            $user_ids = User::select('id')->pluck('id');
            $storage_ids = Storage::select('id')->pluck('id');
            $vendor_ids = Vendor::select('id')
                ->limit(self::VENDOR_COUNT)
                ->pluck('id');

            for ($i = 0; $i < self::MONTH_COUNT; $i++) {
                foreach ($vendor_ids as $vendor_id) {
                    for ($j = 0; $j < self::DELIVERY_ORDER_COUNT_PER_MONTH; $j++) {
                        $this->createVendorDeliveryOrder(
                            $vendor_id, $storage_ids->random(),
                            $user_ids->random(),
                            now()->subMonth($i));
                    }
                }
            }
        });
    }

    private function createVendorDeliveryOrder($vendor_id, $storage_id, $receiver_id, $received_at)
    {
        DeliveryOrder::create([
            'receiver_id' => $receiver_id,
            'source_id' => $vendor_id,
            'source_type' => 'VENDOR',
            'target_id' => $storage_id,
            'target_type' => 'STORAGE',
            'received_at' => $received_at
        ]);
    }
}
