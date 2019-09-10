<?php

use Illuminate\Database\Seeder;
use App\Item;
use App\Vendor;
use App\Category;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            $categories = Category::query()
                ->select("id")
                ->get();

            $vendors = Vendor::query()
                ->select("id")
                ->get();

            $items = factory(Item::class, 100)
                ->create([
                    "category_id" => $categories->random()->id,
                ]);

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
