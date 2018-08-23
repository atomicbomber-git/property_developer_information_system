<?php

use Illuminate\Database\Seeder;
use App\Item;
use App\Vendor;
use App\Category;

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

        $categories = Category::select('id')
            ->get();
        
        foreach ($vendors as $vendor) {
            factory(Item::class, 3)->create([
                'category_id' => $categories->random()->id,
                'vendor_id' => $vendor->id
            ]);
        }
    }
}
