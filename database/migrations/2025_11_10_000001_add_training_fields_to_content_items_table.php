<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('content_items', function (Blueprint $table) {
            $table->string('currency_code', 3)->nullable()->after('currency');
            $table->unsignedInteger('duration_hours')->nullable()->after('duration_days');
            $table->unsignedInteger('session_count')->nullable()->after('duration_hours');
            $table->unsignedInteger('session_length_minutes')->nullable()->after('session_count');
            $table->date('enrollment_deadline')->nullable()->after('is_enrollable');
            $table->string('delivery_mode')->nullable()->after('enrollment_deadline');
            $table->string('level')->nullable()->after('delivery_mode');
            $table->string('language', 50)->nullable()->after('level');
            $table->text('prerequisites')->nullable()->after('language');
            $table->string('instructor_name')->nullable()->after('prerequisites');
            $table->text('instructor_bio')->nullable()->after('instructor_name');
            $table->json('outcomes')->nullable()->after('instructor_bio');
            $table->json('materials_provided')->nullable()->after('outcomes');
            $table->boolean('certification_available')->default(false)->after('materials_provided');
            $table->text('certification_details')->nullable()->after('certification_available');
        });

        DB::table('content_items')
            ->whereNull('currency_code')
            ->whereNotNull('currency')
            ->update(['currency_code' => DB::raw('currency')]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('content_items', function (Blueprint $table) {
            $table->dropColumn([
                'currency_code',
                'duration_hours',
                'session_count',
                'session_length_minutes',
                'enrollment_deadline',
                'delivery_mode',
                'level',
                'language',
                'prerequisites',
                'instructor_name',
                'instructor_bio',
                'outcomes',
                'materials_provided',
                'certification_available',
                'certification_details',
            ]);
        });
    }
};

