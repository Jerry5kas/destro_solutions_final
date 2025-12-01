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
        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->string('locale', 10); // 'en', 'de', etc.
            $table->string('field'); // 'title', 'description', etc.
            $table->text('value')->nullable(); // The translated value
            
            // Polymorphic relationship
            $table->string('translatable_type'); // 'App\Models\ContentItem', etc.
            $table->unsignedBigInteger('translatable_id');
            
            $table->timestamps();
            
            // Indexes for performance - optimized for sync queries
            $table->index(['translatable_type', 'translatable_id'], 'idx_translatable');
            $table->index(['locale', 'field'], 'idx_locale_field');
            $table->index(['locale', 'translatable_type'], 'idx_locale_type');
            $table->index(['translatable_type', 'translatable_id', 'locale'], 'idx_translatable_locale');
            $table->unique(['locale', 'field', 'translatable_type', 'translatable_id'], 'translation_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('translations');
    }
};

