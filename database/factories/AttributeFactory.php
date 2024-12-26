<?php

namespace Database\Factories;

use App\Models\Attribute;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttributeFactory extends Factory
{
    protected $model = Attribute::class;

    public function definition()
    {
        return [
            'product_id' => Product::factory(), // Create a related product
            'name'       => $this->faker->randomElement(['Color', 'Size', 'Material']), // Random attribute name
        ];
    }
}

