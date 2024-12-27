<?php

namespace Database\Factories;

use App\Models\Option;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OptionFactory extends Factory
{
    protected $model = Option::class;

    public function definition()
    {
        return [
            'product_id' => Product::factory(), // Create a related product
            'name' => $this->faker->randomElement(['Color', 'Size', 'Material']), // Random option name
        ];
    }
}
