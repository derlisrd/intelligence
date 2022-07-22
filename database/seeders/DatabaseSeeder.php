<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Derlis',
            'email' => 'derlis@renovaads.com',
            'password' => Hash::make('join1234'),
            'type_user'=>1
        ]);
        // \App\Models\User::factory(10)->create();
    }
}
