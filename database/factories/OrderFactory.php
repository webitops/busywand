<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'order_number' => 'ORD-'.strtoupper($this->faker->unique()->bothify('???###')),
            'customer_id' => Customer::factory(),
            'status_id' => OrderStatus::factory(),
            'subtotal' => $this->faker->randomFloat(2, 50, 500),
            'tax_total' => $this->faker->randomFloat(2, 5, 50),
            'shipping_total' => $this->faker->randomFloat(2, 5, 20),
            'discount_total' => $this->faker->randomFloat(2, 0, 50),
            'total' => 0, // Will be updated after items are added
            'shipping_address' => [
                'street' => $this->faker->streetAddress(),
                'city' => $this->faker->city(),
                'state' => $this->faker->state(),
                'postal_code' => $this->faker->postcode(),
                'country' => $this->faker->country(),
            ],
            'billing_address' => [
                'street' => $this->faker->streetAddress(),
                'city' => $this->faker->city(),
                'state' => $this->faker->state(),
                'postal_code' => $this->faker->postcode(),
                'country' => $this->faker->country(),
            ],
            'notes' => $this->faker->optional()->sentence(),
            'placed_at' => $this->faker->dateTimeBetween('-1 week', 'now'),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Order $order) {
            $items = OrderItem::factory()->count(rand(1, 5))->make();

            $subtotal = 0;
            $taxTotal = 0;
            $discountTotal = 0;

            foreach ($items as $item) {
                $item->order_id = $order->id;
                $item->save();

                $subtotal += $item->subtotal;
                $taxTotal += $item->tax_amount;
                $discountTotal += $item->discount_amount;
            }

            $order->subtotal = $subtotal;
            $order->tax_total = $taxTotal;
            $order->discount_total = $discountTotal;
            $order->total = $subtotal + $taxTotal + $order->shipping_total - $discountTotal;
            $order->save();
        });
    }
}
