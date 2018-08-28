<?php

use Illuminate\Database\Seeder;
use App\Giro;

class GiroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Giro::class, 20)->create();
    }
}
