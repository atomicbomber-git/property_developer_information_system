<?php

use Illuminate\Database\Seeder;
use App\Vendor;
use App\User;
use App\Invoice;

class InvoiceSeeder extends Seeder
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

        foreach ($vendor_ids as $vendor_id) {
            Invoice::create([
                'creator_id' => $user_ids->random(),
                'receiver_id' => $user_ids->random(),
                'vendor_id' => $vendor_id,
                'received_at' => today()
            ]);
        }

        // echo json_encode($users->random(), JSON_PRETTY_PRINT);
    }
}
