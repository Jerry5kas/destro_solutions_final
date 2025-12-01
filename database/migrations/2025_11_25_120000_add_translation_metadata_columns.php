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
        Schema::table('translations', function (Blueprint $table) {
            $table->boolean('is_auto')->default(false)->after('value');
            $table->boolean('locked')->default(false)->after('is_auto');
            $table->timestamp('translated_at')->nullable()->after('locked');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('translations', function (Blueprint $table) {
            $table->dropColumn(['is_auto', 'locked', 'translated_at']);
        });
    }
};

