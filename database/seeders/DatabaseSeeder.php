<?php

namespace Database\Seeders;

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
        \App\Models\User::factory()->create(['email' => 'admin@example.com', 'role' => 'Admin']);
        \App\Models\User::factory(20)->create();
        \App\Models\Category::factory(6)->hasProducts(50)->create();
    }
}
