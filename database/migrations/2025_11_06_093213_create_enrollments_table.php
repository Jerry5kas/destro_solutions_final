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
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('training_id')->constrained('content_items')->onDelete('cascade');
            $table->string('payment_method')->nullable(); // stripe, razorpay
            $table->string('payment_id')->nullable(); // transaction ID from gateway
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('USD');
            $table->string('status')->default('pending'); // pending, paid, failed, refunded, cancelled
            $table->timestamp('enrolled_at')->nullable();
            $table->boolean('terms_accepted')->default(false);
            $table->timestamp('terms_accepted_at')->nullable();
            $table->string('subscription_id')->nullable(); // for recurring payments
            $table->string('subscription_status')->nullable(); // active, cancelled, expired
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'training_id']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
