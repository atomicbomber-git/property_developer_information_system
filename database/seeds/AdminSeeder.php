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
        factory(\App\User::class)->create([
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'privilege' => 'ADMINISTRATOR'
        ]);
    }
}
