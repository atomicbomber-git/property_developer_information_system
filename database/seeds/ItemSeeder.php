<?php

use Illuminate\Database\Seeder;
use App\Item;
use App\Vendor;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vendors = Vendor::select('id')
            ->get();
        
        foreach ($vendors as $vendor) {
            factory(Item::class, 3)->create([
                'vendor_id' => $vendor->id
            ]);
        }
    }
}
