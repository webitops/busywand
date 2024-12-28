<?php

use App\Models\Customer;
use App\Models\CustomerGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

// Customer Tests
it('can create a customer', function () {
    $customer = Customer::factory()->create([
        'name' => 'John Doe',
        'email' => 'johndoe@example.com',
        'phone' => '1234567890',
    ]);

    expect($customer)->toBeInstanceOf(Customer::class)
        ->and($customer->name)->toBe('John Doe')
        ->and($customer->email)->toBe('johndoe@example.com')
        ->and($customer->phone)->toBe('1234567890');
});

it('can update a customer', function () {
    $customer = Customer::factory()->create();

    $customer->update([
        'name' => 'Jane Doe',
        'email' => 'janedoe@example.com',
        'phone' => '9876543210',
    ]);

    expect($customer->fresh()->name)->toBe('Jane Doe')
        ->and($customer->fresh()->email)->toBe('janedoe@example.com')
        ->and($customer->fresh()->phone)->toBe('9876543210');
});

it('can delete a customer', function () {
    $customer = Customer::factory()->create();

    $customer->delete();

    expect(Customer::find($customer->id))->toBeNull();
});

it('can associate a customer with groups', function () {
    $customer = Customer::factory()->create();
    $groups = CustomerGroup::factory(2)->create();

    $customer->customerGroups()->sync($groups);

    expect($customer->customerGroups->count())->toBe(2);
});

// CustomerGroup Tests
it('can create a customer group', function () {
    $group = CustomerGroup::factory()->create([
        'name' => 'VIP',
        'description' => 'Very Important People',
    ]);

    expect($group)->toBeInstanceOf(CustomerGroup::class)
        ->and($group->name)->toBe('VIP')
        ->and($group->description)->toBe('Very Important People');
});

it('can update a customer group', function () {
    $group = CustomerGroup::factory()->create();

    $group->update([
        'name' => 'Premium',
        'description' => 'Premium Customers',
    ]);

    expect($group->fresh()->name)->toBe('Premium')
        ->and($group->fresh()->description)->toBe('Premium Customers');
});

it('can delete a customer group', function () {
    $group = CustomerGroup::factory()->create();

    $group->delete();

    expect(CustomerGroup::find($group->id))->toBeNull();
});

it('can associate a group with customers', function () {
    $group = CustomerGroup::factory()->create();
    $customers = Customer::factory(2)->create();

    $group->customers()->sync($customers);

    expect($group->customers->count())->toBe(2);
});
