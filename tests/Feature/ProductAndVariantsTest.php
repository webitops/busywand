<?php

use App\Models\Option;
use App\Models\OptionValue;
use App\Models\Product;
use App\Models\Variant;

it('can create a product', function () {
    $product = Product::factory()->create([
        'name' => 'T-Shirt',
        'sku' => 'TSHIRT123',
        'description' => 'Comfortable cotton T-shirt',
        'price' => 20.00,
    ]);

    expect($product->name)->toBe('T-Shirt');
    expect($product->sku)->toBe('TSHIRT123');
    expect($product->description)->toBe('Comfortable cotton T-shirt');
    expect($product->price)->toBe(20.00);
});

it('can retrieve associated variants', function () {
    $product = Product::factory()->create();
    Variant::factory()->count(3)->create(['product_id' => $product->id]);

    expect($product->variants)->toHaveCount(3);
    expect($product->variants->first())->toBeInstanceOf(Variant::class);
});

it('can create a variant', function () {
    $product = Product::factory()->create();

    $variant = Variant::factory()->create([
        'product_id' => $product->id,
        'price' => 25.00,
        'stock_quantity' => 10,
    ]);

    expect($variant->product_id)->toBe($product->id);
    expect($variant->price)->toBe(25.00);
    expect($variant->stock_quantity)->toBe(10);
});

it('uses product price as fallback when variant price is null', function () {
    $product = \App\Models\Product::factory()->create(['price' => 30.00]);

    $variant = \App\Models\Variant::factory()->create([
        'product_id' => $product->id,
        'price' => null, // No specific price
        'stock_quantity' => 5,
    ]);

    // Preload the product relationship
    $variant->load('product');

    expect($variant->price)->toBe(30.00); // Falls back to product price
});

it('can create an option for a product', function () {
    $product = Product::factory()->create();

    $option = Option::create([
        'product_id' => $product->id,
        'name' => 'Color',
    ]);

    expect($option->product_id)->toBe($product->id);
    expect($option->name)->toBe('Color');
});

it('can retrieve associated option values', function () {
    $option = Option::factory()->create(['name' => 'Size']);
    OptionValue::factory()->count(3)->create(['option_id' => $option->id]);

    expect($option->values)->toHaveCount(3);
    expect($option->values->first())->toBeInstanceOf(OptionValue::class);
});

it('deletes associated variants when a product is deleted', function () {
    $product = Product::factory()->create();
    Variant::factory()->count(2)->create(['product_id' => $product->id]);

    $product->delete();

    expect(Variant::where('product_id', $product->id)->count())->toBe(0);
});

it('deletes associated option values when an option is deleted', function () {
    $option = Option::factory()->create();
    OptionValue::factory()->count(3)->create(['option_id' => $option->id]);

    $option->delete();

    expect(OptionValue::where('option_id', $option->id)->count())->toBe(0);
});

it('can update stock quantity for a variant', function () {
    $variant = Variant::factory()->create(['stock_quantity' => 10]);

    $variant->stock_quantity += 5;
    $variant->save();

    expect($variant->fresh()->stock_quantity)->toBe(15);
});

it('can create products and variants using factories', function () {
    $product = Product::factory()
        ->has(Variant::factory()->count(3))
        ->create();

    expect($product->variants)->toHaveCount(3);
});

it('runs the ProductSeeder correctly', function () {
    $this->seed(\Database\Seeders\ProductSeeder::class);

    expect(Product::count())->toBeGreaterThan(0);
    expect(Variant::count())->toBeGreaterThan(0);
});
