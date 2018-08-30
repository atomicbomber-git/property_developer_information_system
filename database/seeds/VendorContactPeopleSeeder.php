<?php

use Illuminate\Database\Seeder;

class VendorContactPeopleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vendor_ids = App\Vendor::select('id')->pluck('id');

        foreach ($vendor_ids as $vendor_id) {
            factory(App\VendorContactPerson::class, 3)->create([
                'vendor_id' => $vendor_id
            ]);
        }
    }
}
