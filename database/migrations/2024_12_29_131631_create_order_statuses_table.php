<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('order_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('description')->nullable();
            $table->boolean('is_paid')->default(false);
            $table->boolean('is_delivered')->default(false);
            $table->boolean('is_cancelled')->default(false);
            $table->boolean('is_refunded')->default(false);
            $table->unsignedInteger('order_column')->default(0);
            $table->timestamps();
        });

        Schema::create('order_status_transitions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_status_id')
                ->constrained('order_statuses')
                ->onDelete('cascade');
            $table->foreignId('to_status_id')
                ->constrained('order_statuses')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_status_transitions');
        Schema::dropIfExists('order_statuses');
    }
};
