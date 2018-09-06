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

        

        $storage_ids = Storage::select('id')
            ->pluck('id');



        $do_per_month = $this->command->ask("How many delivery orders per vendor do you want for each month?");
        $vendor_count = $this->command->ask("From how many vendors?");
        $month_count = $this->command->ask("From how many months back from now?");

        $vendor_ids = Vendor::query()
            ->select('id')
            ->limit($vendor_count)
            ->pluck('id');

        for ($i = 0; $i < $month_count; $i++) {
            foreach ($vendor_ids as $vendor_id) {
                for ($j = 0; $j < $do_per_month; $j++) {
                    $this->createVendorDeliveryOrder(
                        $vendor_id, $storage_ids->random(),
                        $user_ids->random(),
                        now()->subMonth($i));
                }
            }
        }
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
