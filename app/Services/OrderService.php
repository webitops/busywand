<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\Variant;
use Exception;
use Illuminate\Support\Facades\DB;

class OrderService
{
    /**
     * Create a new order.
     *
     * @throws Exception
     */
    public function createOrder(array $data): Order
    {
        return DB::transaction(function () use ($data) {
            // Validate and retrieve customer
            $customer = Customer::findOrFail($data['customer_id']);

            // Validate and retrieve status
            $status = OrderStatus::findOrFail($data['status_id']);

            // Calculate order totals
            $subtotal = 0;
            $taxTotal = 0;
            $shippingTotal = $data['shipping_total'] ?? 0;
            $discountTotal = $data['discount_total'] ?? 0;

            // Create order
            $order = Order::create([
                'order_number' => $this->generateOrderNumber(),
                'customer_id' => $customer->id,
                'status_id' => $status->id,
                'subtotal' => $subtotal,
                'tax_total' => $taxTotal,
                'shipping_total' => $shippingTotal,
                'discount_total' => $discountTotal,
                'total' => 0, // This will be updated after items are added
                'shipping_address' => $data['shipping_address'] ?? 'n/a',
                'billing_address' => $data['billing_address'] ?? null,
                'notes' => $data['notes'] ?? null,
                'placed_at' => now(),
            ]);

            // Add order items
            $items = $data['order']['variants'] ?? [];
            foreach ($items as $item) {
                $variant = Variant::findOrFail($item['id']);
                $unitPrice = $variant->price; // Assuming `price` exists on Variant
                $quantity = $item['quantity'];
                $subtotal = $unitPrice * $quantity;

                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'variant_id' => $variant->id,
                    'name' => $variant->product->name, // Assuming `product` relationship exists
                    'sku' => $variant->sku,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'tax_amount' => $item['tax_amount'] ?? 0,
                    'discount_amount' => $item['discount_amount'] ?? 0,
                    'subtotal' => $subtotal,
                    'total' => $subtotal + ($item['tax_amount'] ?? 0) - ($item['discount_amount'] ?? 0),
                    'options' => $item['options'] ?? null,
                ]);

                $order->subtotal += $orderItem->subtotal;
                $order->tax_total += $orderItem->tax_amount;
                $order->discount_total += $orderItem->discount_amount;
            }

            // Update order totals
            $order->total = $order->subtotal + $order->tax_total + $order->shipping_total - $order->discount_total;
            $order->save();

            return $order;
        });
    }

    /**
     * Update an existing order.
     *
     * @throws Exception
     */
    public function updateOrder(Order $order, array $data): Order
    {
        return DB::transaction(function () use ($order, $data) {
            if (isset($data['status_id'])) {
                $status = OrderStatus::findOrFail($data['status_id']);
                $order->status_id = $status->id;
            }

            if (isset($data['shipping_address'])) {
                $order->shipping_address = $data['shipping_address'];
            }

            if (isset($data['billing_address'])) {
                $order->billing_address = $data['billing_address'];
            }

            if (isset($data['notes'])) {
                $order->notes = $data['notes'];
            }

            $order->save();

            return $order;
        });
    }

    /**
     * Delete an order.
     *
     * @throws Exception
     */
    public function deleteOrder(Order $order): ?bool
    {
        return $order->delete();
    }

    /**
     * Generate a unique order number.
     */
    private function generateOrderNumber(): string
    {
        return 'ORD-'.strtoupper(uniqid());
    }
}
