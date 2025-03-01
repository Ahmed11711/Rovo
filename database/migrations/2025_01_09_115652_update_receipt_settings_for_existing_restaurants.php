<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Restaurant;
use App\Models\ReceiptSetting;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update the receipt settings table to use the new column names
        // created in the previous migration
        if (Schema::hasColumn('receipt_settings', 'showCustomerName')) {
            Schema::table('receipt_settings', function (Blueprint $table) {
                $table->renameColumn('showCustomerName', 'show_customer_name');
                $table->renameColumn('showCustomerAddress', 'show_customer_address');
                $table->renameColumn('showTableNumber', 'show_table_number');
                $table->renameColumn('showPaymentQrCode', 'show_payment_qr_code');
                $table->renameColumn('showWaiter', 'show_waiter');
                $table->renameColumn('showTotalGuest', 'show_total_guest');
                $table->renameColumn('showRestaurantLogo', 'show_restaurant_logo');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
