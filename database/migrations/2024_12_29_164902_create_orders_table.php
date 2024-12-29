<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Orders table
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('customer_id')->constrained()->onDelete('restrict');
            $table->foreignId('status_id')->constrained('order_statuses')->onDelete('restrict'); // Tracks order status
            $table->decimal('subtotal', 12, 4);
            $table->decimal('tax_total', 12, 4)->default(0);
            $table->decimal('shipping_total', 12, 4)->default(0);
            $table->decimal('discount_total', 12, 4)->default(0);
            $table->decimal('total', 12, 4);
            $table->json('shipping_address');
            $table->json('billing_address')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('placed_at')->nullable(); // When the order was placed
            $table->timestamps();
        });

        // Order items table
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // Links to orders
            $table->foreignId('variant_id')->constrained()->onDelete('restrict'); // Links to product variants
            $table->string('name'); // Product name at the time of order
            $table->string('sku'); // Product SKU at the time of order
            $table->integer('quantity');
            $table->decimal('unit_price', 12, 4);
            $table->decimal('tax_amount', 12, 4)->default(0);
            $table->decimal('discount_amount', 12, 4)->default(0);
            $table->decimal('subtotal', 12, 4); // Quantity * Unit Price
            $table->decimal('total', 12, 4); // Subtotal + Tax - Discount
            $table->json('options')->nullable(); // Any additional options (e.g., color, size)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
