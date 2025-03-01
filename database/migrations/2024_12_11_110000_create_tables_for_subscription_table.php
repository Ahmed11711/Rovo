<?php

use App\Enums\PackageType;
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
        if (!Schema::hasTable('package_modules')) {
            Schema::create('package_modules', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('package_id')->nullable();
                $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade')->onUpdate('cascade');
                $table->unsignedBigInteger('module_id')->nullable();
                $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade')->onUpdate('cascade');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('offline_payment_methods')) {
            Schema::create('offline_payment_methods', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('restaurant_id')->nullable();
                $table->foreign('restaurant_id')->references('id')->on('restaurants')->onDelete('cascade')->onUpdate('cascade');
                $table->string('name');
                $table->text('description')->nullable();
                $table->enum('status', ['active', 'inactive'])->default('active');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('global_subscriptions')) {
            Schema::create('global_subscriptions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('restaurant_id')->nullable();
                $table->foreign('restaurant_id')->references('id')->on('restaurants')->onDelete('cascade')->onUpdate('cascade');
                $table->unsignedBigInteger('package_id')->nullable();
                $table->foreign('package_id')->references('id')->on('packages')->onDelete('SET NULL')->onUpdate('cascade');
                $table->unsignedBigInteger('currency_id')->nullable();
                $table->foreign('currency_id')->references('id')->on('global_currencies')->onDelete('cascade')->onUpdate('cascade');
                $table->string('package_type')->nullable();
                $table->string('plan_type')->nullable();
                $table->string('transaction_id')->nullable();
                $table->string('name')->nullable();
                $table->string('user_id')->nullable();
                $table->string('quantity')->nullable();
                $table->string('token')->nullable();
                $table->string('razorpay_id')->nullable();
                $table->string('razorpay_plan')->nullable();
                $table->string('stripe_id')->nullable();
                $table->string('stripe_status')->nullable();
                $table->string('stripe_price')->nullable();
                $table->string('gateway_name')->nullable();
                $table->string('trial_ends_at')->nullable();
                $table->enum('subscription_status', ['active', 'inactive'])->nullable()->default(null);
                $table->dateTime('ends_at')->nullable();
                $table->dateTime('subscribed_on_date')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('global_invoices')) {
            Schema::create('global_invoices', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('restaurant_id')->nullable();
                $table->foreign('restaurant_id')->references('id')->on('restaurants')->onDelete('cascade')->onUpdate('cascade');
                $table->unsignedBigInteger('currency_id')->nullable();
                $table->foreign('currency_id')->references('id')->on('global_currencies')->onDelete('cascade')->onUpdate('cascade');
                $table->unsignedBigInteger('package_id')->nullable();
                $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade')->onUpdate('cascade');
                $table->unsignedBigInteger('global_subscription_id')->nullable();
                $table->foreign('global_subscription_id')->references('id')->on('global_subscriptions')->onDelete('cascade')->onUpdate('cascade');
                $table->unsignedBigInteger('offline_method_id')->nullable();
                $table->foreign('offline_method_id')->references('id')->on('offline_payment_methods')->onDelete('cascade')->onUpdate('cascade');
                $table->string('signature')->nullable();
                $table->string('token')->nullable();
                $table->string('transaction_id')->nullable();
                $table->string('package_type')->nullable();
                $table->integer('sub_total')->nullable();
                $table->integer('total')->nullable();
                $table->string('billing_frequency')->nullable();
                $table->string('billing_interval')->nullable();
                $table->enum('recurring', ['yes', 'no'])->nullable()->default(null);
                $table->string('plan_id')->nullable();
                $table->string('subscription_id')->nullable();
                $table->string('invoice_id')->nullable();
                $table->double('amount', 16, 2)->nullable();
                $table->string('stripe_invoice_number')->nullable();
                $table->dateTime('pay_date')->nullable();
                $table->dateTime('next_pay_date')->nullable();
                $table->string('gateway_name')->nullable();
                $table->enum('status', ['active', 'inactive'])->nullable()->default(null);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('offline_plan_changes')) {
            Schema::create('offline_plan_changes', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('restaurant_id')->nullable();
                $table->foreign('restaurant_id')->references('id')->on('restaurants')->onDelete('cascade')->onUpdate('cascade');
                $table->unsignedBigInteger('package_id');
                $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade')->onUpdate('cascade');
                $table->string('package_type');
                $table->double('amount', 16, 2)->nullable();
                $table->date('pay_date')->nullable();
                $table->date('next_pay_date')->nullable();
                $table->unsignedBigInteger('invoice_id')->nullable();
                $table->foreign('invoice_id')->references('id')->on('global_invoices')->onDelete('cascade')->onUpdate('cascade');
                $table->unsignedBigInteger('offline_method_id')->nullable();
                $table->foreign('offline_method_id')->references('id')->on('offline_payment_methods')->onDelete('cascade')->onUpdate('cascade');
                $table->string('file_name')->nullable();
                $table->enum('status', ['verified', 'pending', 'rejected'])->default('pending');
                $table->text('remark')->nullable();
                $table->mediumText('description');
                $table->timestamps();
            });
        }

        if (Schema::hasTable('packages')) {
            Schema::table('packages', function (Blueprint $table) {
                $table->string('description')->nullable();
                $table->double('annual_price', 16, 2)->nullable();
                $table->double('monthly_price', 16, 2)->nullable();
                $table->string('monthly_status')->nullable()->default(1);
                $table->string('annual_status')->nullable()->default(1);
                $table->string('stripe_annual_plan_id')->nullable();
                $table->string('stripe_monthly_plan_id')->nullable();
                $table->string('razorpay_annual_plan_id')->nullable();
                $table->string('razorpay_monthly_plan_id')->nullable();
                $table->string('paystack_annual_plan_id')->nullable();
                $table->string('paystack_monthly_plan_id')->nullable();
                $table->string('stripe_lifetime_plan_id')->nullable();
                $table->string('razorpay_lifetime_plan_id')->nullable();
                $table->unsignedTinyInteger('billing_cycle')->nullable();
                $table->unsignedInteger('sort_order')->nullable();
                $table->boolean('is_private')->default(0);
                $table->boolean('is_free')->default(0);
                $table->boolean('is_recommended')->default(0);
                $table->string('package_type')->default(PackageType::STANDARD);
                $table->boolean('trial_status')->nullable();
                $table->integer('trial_days')->nullable();
                $table->integer('trial_notification_before_days')->nullable();
                $table->string('trial_message')->nullable();
                $table->longText('additional_features')->nullable();
            });
        }

        if (Schema::hasTable('restaurants')) {
            Schema::table('restaurants', function (Blueprint $table) {
            $table->unsignedBigInteger('package_id')->nullable();
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('SET NULL')->onUpdate('cascade');
            $table->string('package_type')->nullable();
            $table->enum('status', ['active', 'inactive', 'license_expired'])->default('active');
            $table->datetime('license_expire_on')->nullable();
            $table->datetime('trial_ends_at')->nullable();
            $table->datetime('license_updated_at')->nullable();
            $table->datetime('subscription_updated_at')->nullable();
            $table->string('stripe_id')->nullable();
            $table->string('pm_type')->nullable();
            $table->string('pm_last_four', 4)->nullable();
            });
        }

        if(Schema::hasTable('restaurant_payments')) {
            Schema::table('restaurant_payments', function (Blueprint $table) {
                $table->string('package_type')->nullable();
                $table->string('currency_id')->nullable();
            });
        }

        if (!Schema::hasColumn('users', 'stripe_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('stripe_id')->nullable()->index();
                $table->string('pm_type')->nullable();
                $table->string('pm_last_four', 4)->nullable();
                $table->timestamp('trial_ends_at')->nullable();
            });
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop foreign keys and tables
        Schema::table('global_invoices', function (Blueprint $table) {
            $table->dropForeign(['offline_method_id']);
            $table->dropForeign(['global_subscription_id']);
            $table->dropForeign(['currency_id']);
            $table->dropForeign(['package_id']);
            $table->dropForeign(['restaurant_id']);
        });

        Schema::table('offline_plan_changes', function (Blueprint $table) {
            $table->dropForeign(['offline_method_id']);
            $table->dropForeign(['invoice_id']);
            $table->dropForeign(['package_id']);
            $table->dropForeign(['restaurant_id']);
        });

        Schema::table('global_subscriptions', function (Blueprint $table) {
            $table->dropForeign(['currency_id']);
            $table->dropForeign(['package_id']);
            $table->dropForeign(['restaurant_id']);
        });

        Schema::table('packages', function (Blueprint $table) {

            // Drop the actual columns
            $table->dropColumn('description');
            $table->dropColumn('annual_price');
            $table->dropColumn('monthly_price');
            $table->dropColumn('monthly_status');
            $table->dropColumn('annual_status');
            $table->dropColumn('stripe_annual_plan_id');
            $table->dropColumn('stripe_monthly_plan_id');
            $table->dropColumn('razorpay_annual_plan_id');
            $table->dropColumn('razorpay_monthly_plan_id');
            $table->dropColumn('paystack_annual_plan_id');
            $table->dropColumn('paystack_monthly_plan_id');
            $table->string('stripe_lifetime_plan_id')->nullable();
            $table->string('razorpay_lifetime_plan_id')->nullable();
            $table->dropColumn('billing_cycle');
            $table->dropColumn('sort_order');
            $table->dropColumn('is_private');
            $table->dropColumn('is_free');
            $table->dropColumn('is_recommended');
            $table->dropColumn('package_type');
            $table->dropColumn('trial_days');
            $table->dropColumn('trial_status');
            $table->dropColumn('trial_notification_before_days');
            $table->dropColumn('trial_message');
            $table->dropColumn('additional_features');
        });

        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropForeign(['package_id']);
            $table->dropColumn('package_id');
            $table->dropColumn('package_type');
            $table->dropColumn('status');
            $table->dropColumn('license_expire_on');
            $table->dropColumn('trial_ends_at');
            $table->dropColumn('license_updated_at');
            $table->dropColumn('subscription_updated_at');
            $table->dropColumn('stripe_id');
            $table->dropColumn('pm_type');
            $table->dropColumn('pm_last_four');
        });

        Schema::table('restaurant_payments', function (Blueprint $table) {
            $table->dropColumn('package_type');
            $table->dropColumn('currency_id');
        });

        Schema::dropIfExists('package_modules');
        Schema::dropIfExists('offline_payment_methods');
        Schema::dropIfExists('global_subscriptions');
        Schema::dropIfExists('offline_plan_changes');
        Schema::dropIfExists('global_invoices');
        Schema::dropIfExists('stripe_invoices');
        Schema::dropIfExists('razorpay_invoices');

        if (Schema::hasColumn('users', 'stripe_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('stripe_id');
                $table->dropColumn('pm_type');
                $table->dropColumn('pm_last_four');
                $table->dropColumn('trial_ends_at');
            });
        }
    }

};
