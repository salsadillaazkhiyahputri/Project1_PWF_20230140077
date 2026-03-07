<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'quantity' => $this->faker->numberBetween(1,100),
            'price' => $this->faker->randomFloat(2,1000,9000000),
            'user_id' => 1,
            'category_id' => Category::all()->random()->id
        ];
    }
}