<?php

use App\Models\OrderStatus;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

beforeEach(function () {
    $this->user = User::factory()->create();
    actingAs($this->user);
});

it('lists order statuses', function () {
    $status = OrderStatus::factory()->create();

    $response = get(route('order-statuses.index'));
    $response->assertOk()
        ->assertSee($status->name);
});

it('creates an order status', function () {
    $data = [
        'name' => 'New Status',
        'description' => 'Test description',
        'is_paid' => true,
    ];

    $response = post(route('order-statuses.store'), $data);
    $response->assertRedirect(route('order-statuses.index'));

    expect(OrderStatus::where('name', 'New Status')->exists())->toBeTrue();
});

it('updates an order status', function () {
    $status = OrderStatus::factory()->create([
        'name' => 'Old Status',
    ]);

    $data = [
        'name' => 'Updated Status',
        'is_cancelled' => true,
    ];

    $response = put(route('order-statuses.update', $status), $data);
    $response->assertRedirect(route('order-statuses.index'));

    $status->refresh();
    expect($status->name)->toBe('Updated Status');
    expect($status->is_cancelled)->toBeTrue();
});

it('deletes an order status', function () {
    $status = OrderStatus::factory()->create();

    $response = delete(route('order-statuses.destroy', $status));
    $response->assertRedirect(route('order-statuses.index'));

    expect(OrderStatus::find($status->id))->toBeNull();
});
