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
            $table->enum('order_type', ['dine_in', 'delivery', 'pickup'])->default('dine_in');
            $table->enum('status', ['draft', 'kot', 'billed', 'paid', 'canceled', 'payment_due', 'ready', 'out_for_delivery', 'delivered'])->default('kot')->change();
            $table->foreignId('delivery_executive_id')->nullable()->constrained('delivery_executives')->onDelete('set null');
            $table->text('delivery_address')->nullable();
            $table->datetime('delivery_time')->nullable();
            $table->datetime('estimated_delivery_time')->nullable();
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->text('delivery_address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('delivery_address');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['delivery_executive_id']);
            $table->dropColumn(['order_type', 'delivery_address', 'delivery_time', 'estimated_delivery_time', 'delivery_executive_id']);
            $table->enum('status', ['draft', 'kot', 'billed', 'paid', 'canceled', 'payment_due'])->default('kot')->change();
        });
    }

};
