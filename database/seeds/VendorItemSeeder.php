<?php

use App\Item;
use App\Vendor;
use Illuminate\Database\Seeder;

class VendorItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            $vendors = Vendor::query()
                ->select("id")
                ->get();

            $items = Item::query()
                ->select("id")
                ->get();

            $vendors->each(function ($vendor) use($items) {
                $items->shuffle()
                    ->take(rand(10, 20))
                    ->each(function ($random_item) use($vendor) {
                        $vendor->items()->attach($random_item);
                    });
            });
        });
    }
}
