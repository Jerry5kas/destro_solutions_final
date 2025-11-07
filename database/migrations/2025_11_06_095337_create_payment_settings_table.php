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
        Schema::create('payment_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('stripe_enabled')->default(true);
            $table->boolean('razorpay_enabled')->default(true);
            $table->string('default_gateway')->default('stripe');
            $table->timestamps();
        });

        // Seed an initial row
        \DB::table('payment_settings')->insert([
            'stripe_enabled' => true,
            'razorpay_enabled' => true,
            'default_gateway' => 'stripe',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_settings');
    }
};
