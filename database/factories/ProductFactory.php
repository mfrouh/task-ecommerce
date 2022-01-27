<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'name' => 'Product '.rand(1,99999),
            'price' => rand(50, 600),
            'image' => 'images/products/' . rand(1, 10).'.jpg',
            'quantity' => rand(4, 300),
            'status' => rand(0, 1),
            'description' => $this->faker->text,
            'category_id' => Category::all()->random()->id,
        ];
    }
}
