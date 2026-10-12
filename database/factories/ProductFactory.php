<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'sku' => fake()->unique()->bothify('SKU-####'),
            'name' => ucfirst(fake()->words(3, true)),
            'price' => fake()->numberBetween(5, 500) * 1000,
            'stock' => fake()->numberBetween(0, 100),
            'minimum_stock' => fake()->numberBetween(5, 15),
        ];
    }
}
