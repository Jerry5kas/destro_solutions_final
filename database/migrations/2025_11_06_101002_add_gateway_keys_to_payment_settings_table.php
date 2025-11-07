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
        Schema::table('payment_settings', function (Blueprint $table) {
            $table->string('stripe_key')->nullable()->after('default_gateway');
            $table->string('stripe_secret')->nullable()->after('stripe_key');
            $table->string('stripe_webhook_secret')->nullable()->after('stripe_secret');

            $table->string('razorpay_key')->nullable()->after('stripe_webhook_secret');
            $table->string('razorpay_secret')->nullable()->after('razorpay_key');
            $table->string('razorpay_webhook_secret')->nullable()->after('razorpay_secret');

            $table->string('currency', 6)->default('USD')->after('razorpay_webhook_secret');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_settings', function (Blueprint $table) {
            $table->dropColumn([
                'stripe_key','stripe_secret','stripe_webhook_secret',
                'razorpay_key','razorpay_secret','razorpay_webhook_secret',
                'currency'
            ]);
        });
    }
};
