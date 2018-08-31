<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\User::class)->states('admin')->create([
            'username' => 'admin',
            'name' => 'Alyta',
            'password' => bcrypt('admin')
        ]);
    }
}
