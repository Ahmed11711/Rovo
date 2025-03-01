<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Restaurant;

return new class extends Migration
{

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('receipt_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('restaurant_id')->nullable();
            $table->foreign('restaurant_id')->references('id')->on('restaurants')->onDelete('cascade')->onUpdate('cascade');
            $table->boolean('show_customer_name')->default(false);
            $table->boolean('show_customer_address')->default(false);
            $table->boolean('show_table_number')->default(false);
            $table->boolean('show_payment_qr_code')->default(false);
            $table->boolean('show_waiter')->default(false);
            $table->boolean('show_total_guest')->default(false);
            $table->boolean('show_restaurant_logo')->default(false);
            $table->timestamps();
        });

        $restaurants = Restaurant::doesntHave('receiptSetting')->get();

        foreach ($restaurants as $restaurant) {
            $restaurant->receiptSetting()->create();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipt_settings');
    }
};
