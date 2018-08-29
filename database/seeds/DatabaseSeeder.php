<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(VendorSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ItemSeeder::class);
        $this->call(StorageSeeder::class);
        // $this->call(DeliveryOrderSeeder::class);
        // $this->call(DeliveryOrderItemSeeder::class);
        // $this->call(InternalDeliveryOrderSeeder::class);
        // $this->call(InvoiceSeeder::class);
        // $this->call(GiroSeeder::class);
    }
}
