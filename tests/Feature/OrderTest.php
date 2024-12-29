<?php

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Variant;
use App\Services\OrderService;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

beforeEach(function () {
    $this->customer = Customer::factory()->create();
    $this->status = OrderStatus::factory()->create();
    $this->variant = Variant::factory()->create();
    $this->orderService = app(OrderService::class);
});

it('creates an order', function () {
    $data = [
        'customer_id' => $this->customer->id,
        'status_id' => $this->status->id,
        'shipping_address' => [
            'street' => '123 Main St',
            'city' => 'Anytown',
            'state' => 'CA',
            'postal_code' => '12345',
            'country' => 'USA',
        ],
        'billing_address' => [
            'street' => '123 Main St',
            'city' => 'Anytown',
            'state' => 'CA',
            'postal_code' => '12345',
            'country' => 'USA',
        ],
        'notes' => 'Test order',
        'items' => [
            [
                'variant_id' => $this->variant->id,
                'quantity' => 2,
                'tax_amount' => 1.5,
                'discount_amount' => 0.5,
            ],
        ],
    ];

    $order = $this->orderService->createOrder($data);

    expect($order)->toBeInstanceOf(Order::class);
    expect($order->customer_id)->toBe($this->customer->id);
    expect($order->status_id)->toBe($this->status->id);
});

it('updates an order', function () {
    $order = Order::factory()->create(['customer_id' => $this->customer->id, 'status_id' => $this->status->id]);

    $data = [
        'status_id' => $this->status->id,
        'shipping_address' => [
            'street' => '456 New St',
            'city' => 'Newtown',
            'state' => 'NY',
            'postal_code' => '67890',
            'country' => 'USA',
        ],
        'billing_address' => [
            'street' => '456 New St',
            'city' => 'Newtown',
            'state' => 'NY',
            'postal_code' => '67890',
            'country' => 'USA',
        ],
        'notes' => 'Updated notes',
    ];

    $updatedOrder = $this->orderService->updateOrder($order, $data);

    expect($updatedOrder->shipping_address['street'])->toBe('456 New St');
    expect($updatedOrder->billing_address['street'])->toBe('456 New St');
    expect($updatedOrder->notes)->toBe('Updated notes');
});

it('deletes an order', function () {
    $order = Order::factory()->create(['customer_id' => $this->customer->id, 'status_id' => $this->status->id]);

    $result = $this->orderService->deleteOrder($order);

    expect($result)->toBeTrue();
    $this->assertDatabaseMissing('orders', [
        'id' => $order->id,
    ]);
});

it('retrieves an order', function () {
    $order = Order::factory()->create(['customer_id' => $this->customer->id, 'status_id' => $this->status->id]);

    $retrievedOrder = Order::find($order->id);

    expect($retrievedOrder)->toBeInstanceOf(Order::class);
    expect($retrievedOrder->customer_id)->toBe($this->customer->id);
});

it('lists all orders', function () {
    $user = \App\Models\User::factory()->create(); // Ensure user authentication
    actingAs($user);

    Order::factory()->count(5)->create(['customer_id' => $this->customer->id]);

    $response = get('/orders');

    $response->assertStatus(200);
    $response->assertSee('Orders'); // Check that the Inertia page renders
});
