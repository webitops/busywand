<?php

namespace Database\Factories;

use App\Models\OrderStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OrderStatus>
 */
class OrderStatusFactory extends Factory
{
    protected $model = OrderStatus::class;

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word(),
            'description' => $this->faker->sentence(),
            'is_paid' => $this->faker->boolean(),
            'is_delivered' => $this->faker->boolean(),
            'is_cancelled' => $this->faker->boolean(false), // Less likely to start as cancelled
            'is_refunded' => $this->faker->boolean(false), // Less likely to start as refunded
            'order_column' => $this->faker->randomDigitNotNull(), // For sortable integration
        ];
    }

    /**
     * Indicate the status is paid.
     */
    public function paid()
    {
        return $this->state(function (array $attributes) {
            return ['is_paid' => true];
        });
    }

    /**
     * Indicate the status is delivered.
     */
    public function delivered()
    {
        return $this->state(function (array $attributes) {
            return ['is_delivered' => true];
        });
    }

    /**
     * Indicate the status is cancelled.
     */
    public function cancelled()
    {
        return $this->state(function (array $attributes) {
            return ['is_cancelled' => true];
        });
    }

    /**
     * Indicate the status is refunded.
     */
    public function refunded()
    {
        return $this->state(function (array $attributes) {
            return ['is_refunded' => true];
        });
    }
}
