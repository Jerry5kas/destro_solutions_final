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
        Schema::table('content_items', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->nullable()->after('status');
            $table->string('currency', 3)->default('USD')->after('price');
            $table->integer('duration_days')->nullable()->after('currency');
            $table->integer('max_students')->nullable()->after('duration_days');
            $table->date('start_date')->nullable()->after('max_students');
            $table->date('end_date')->nullable()->after('start_date');
            $table->boolean('is_enrollable')->default(false)->after('end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('content_items', function (Blueprint $table) {
            $table->dropColumn([
                'price',
                'currency',
                'duration_days',
                'max_students',
                'start_date',
                'end_date',
                'is_enrollable',
            ]);
        });
    }
};
