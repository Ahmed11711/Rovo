<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('split_type', ['even', 'custom', 'items'])->nullable();
        });

        Schema::create('split_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders');
            $table->double('amount', 16, 2);
            $table->enum('status', ['pending', 'paid'])->default('pending');
            $table->enum('payment_method', ['cash', 'upi', 'card', 'due', 'stripe', 'razorpay'])->default('cash');
            $table->timestamps();
        });

        Schema::create('split_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('split_order_id')->constrained('split_orders');
            $table->foreignId('order_item_id')->constrained('order_items');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('split_order_items');
        Schema::dropIfExists('split_orders');

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('split_type');
        });
    }
};
