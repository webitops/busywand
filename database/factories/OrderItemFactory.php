<?php

namespace Database\Factories;

use App\Models\OrderItem;
use App\Models\Variant;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    public function definition()
    {
        $variant = Variant::factory()->create();

        $quantity = $this->faker->numberBetween(1, 5);
        $unitPrice = $variant->price;
        $subtotal = $quantity * $unitPrice;

        return [
            'variant_id' => $variant->id,
            'name' => $variant->product->name,
            'sku' => $variant->sku,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'tax_amount' => $this->faker->randomFloat(2, 0, 10),
            'discount_amount' => $this->faker->randomFloat(2, 0, 5),
            'subtotal' => $subtotal,
            'total' => $subtotal + $this->faker->randomFloat(2, 0, 10) - $this->faker->randomFloat(2, 0, 5),
            'options' => $this->faker->optional()->randomElements(['color' => 'red', 'size' => 'L']),
        ];
    }
}
