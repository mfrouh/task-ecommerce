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
        for ($i = 1; $i <= 20; $i++) {
            \App\Models\User::factory()->create(['email' => "customer$i@example.com"]);
        }
        foreach (['Men', 'Women', 'Kids'] as $key => $value) {
            \App\Models\Category::factory()->hasProducts(50)->create(['name' => $value]);
        }
    }
}
