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
        if (!Schema::hasColumn('content_items', 'slug')) {
            Schema::table('content_items', function (Blueprint $table) {
                $table->string('slug')->nullable()->after('title');
            });
        }
        
        // Generate slugs for existing records
        $items = \App\Models\ContentItem::where(function($query) {
            $query->whereNull('slug')->orWhere('slug', '');
        })->get();
        
        foreach ($items as $item) {
            $baseSlug = \Illuminate\Support\Str::slug($item->title);
            $slug = $baseSlug;
            $counter = 1;
            while (\App\Models\ContentItem::where('slug', $slug)->where('id', '!=', $item->id)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }
            $item->update(['slug' => $slug]);
        }
        
        // Now make it unique and not nullable if not already
        if (Schema::hasColumn('content_items', 'slug')) {
            Schema::table('content_items', function (Blueprint $table) {
                $table->string('slug')->unique()->nullable(false)->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('content_items', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
