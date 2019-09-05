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
        DB::transaction(function() {
            factory(DeliveryOrder::class, 100)
                ->create([
                    "received_at" => today()
                        ->subMonth(rand(0, 24))
                        ->subDay(rand(0, 31))
                ]);
        });
    }
}
