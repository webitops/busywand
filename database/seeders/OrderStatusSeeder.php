<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed statuses
        $statuses = [
            [
                'name' => 'Pending',
                'description' => 'Order placed, awaiting processing',
                'is_paid' => false,
                'is_delivered' => false,
                'is_cancelled' => false,
                'is_refunded' => false,
                'order_column' => 1,
            ],
            [
                'name' => 'Processing',
                'description' => 'Order is being prepared',
                'is_paid' => true,
                'is_delivered' => false,
                'is_cancelled' => false,
                'is_refunded' => false,
                'order_column' => 2,
            ],
            [
                'name' => 'Shipped',
                'description' => 'Order has been shipped',
                'is_paid' => true,
                'is_delivered' => false,
                'is_cancelled' => false,
                'is_refunded' => false,
                'order_column' => 3,
            ],
            [
                'name' => 'Delivered',
                'description' => 'Order delivered to the customer',
                'is_paid' => true,
                'is_delivered' => true,
                'is_cancelled' => false,
                'is_refunded' => false,
                'order_column' => 4,
            ],
            [
                'name' => 'Cancelled',
                'description' => 'Order has been cancelled',
                'is_paid' => false,
                'is_delivered' => false,
                'is_cancelled' => true,
                'is_refunded' => false,
                'order_column' => 5,
            ],
            [
                'name' => 'Refunded',
                'description' => 'Order has been refunded',
                'is_paid' => false,
                'is_delivered' => false,
                'is_cancelled' => true,
                'is_refunded' => true,
                'order_column' => 6,
            ],
        ];

        $statusIds = [];
        foreach ($statuses as $status) {
            $statusIds[$status['name']] = OrderStatus::create($status)->id;
        }

        // Configure allowed transitions
        $transitions = [
            'Pending' => ['Processing', 'Cancelled'],
            'Processing' => ['Shipped', 'Cancelled'],
            'Shipped' => ['Delivered', 'Cancelled'],
            'Delivered' => [],
            'Cancelled' => [],
            'Refunded' => [],
        ];

        foreach ($transitions as $fromStatus => $toStatuses) {
            $fromStatusId = $statusIds[$fromStatus];
            $toStatusIds = array_map(fn ($status) => $statusIds[$status], $toStatuses);

            OrderStatus::find($fromStatusId)->allowedNextStatuses()->sync($toStatusIds);
        }
    }
}
