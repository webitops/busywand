<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Variant;
use Illuminate\Database\Eloquent\Factories\Factory;

class VariantFactory extends Factory
{
    protected $model = Variant::class;

    public function definition()
    {
        return [
            'product_id'     => Product::factory(), // Create a product if not already linked
            'price'          => $this->faker->randomFloat(2, 10, 100), // Random price between 10 and 100
            'stock_quantity' => $this->faker->numberBetween(0, 100), // Random stock quantity
        ];
    }
}
