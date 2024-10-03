<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'profit_margin' => $this->faker->randomFloat(2, 0, 1), // Random margin between 0 and 1
            'shipping_cost' => $this->faker->randomFloat(2, 0, 20), // Random shipping cost
            'enabled' => $this->faker->boolean(),
        ];
    }
}
