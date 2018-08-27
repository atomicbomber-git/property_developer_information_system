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

        $vendor_ids = Vendor::limit(3)
            ->select('id')
            ->pluck('id');

        $storage_ids = Storage::select('id')
            ->pluck('id');

        foreach ($vendor_ids as $vendor_id) {
            DeliveryOrder::create([
                'receiver_id' => $user_ids->random(),
                'source_id' => $vendor_id,
                'source_type' => 'VENDOR',
                'target_id' => $storage_ids->random(),
                'target_type' => 'STORAGE',
                'received_at' => today()
            ]);
        }
    }
}
