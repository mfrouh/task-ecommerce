<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'price' => rand(50, 600),
            'image' => UploadedFile::fake()->image('avatar.png'),
            'quantity' => rand(4, 300),
            'status' => rand(0, 1),
            'description' => $this->faker->text,
            'category_id' => Category::factory()->create()->id,
        ];
    }
}
