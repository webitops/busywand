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
            'name'        => $this->faker->word(),
            'sku'         => $this->faker->unique()->word(),
            'description' => $this->faker->sentence(),
            'price'       => $this->faker->randomFloat(2, 10, 100),
        ];
    }
}
