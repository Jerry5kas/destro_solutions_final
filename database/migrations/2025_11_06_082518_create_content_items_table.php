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
        Schema::create('content_items', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // quantum, services, products, training, blog
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('category')->nullable();
            $table->date('date')->nullable();
            $table->json('objective_list')->nullable(); // Array of objectives
            $table->string('image')->nullable();
            $table->string('status')->default('active'); // active, inactive, waiting
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_items');
    }
};
