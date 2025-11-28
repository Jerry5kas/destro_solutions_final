<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentItem;
use App\Models\Translation;
use App\Services\TranslationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TranslationController extends Controller
{
    protected TranslationService $translationService;

    public function __construct(TranslationService $translationService)
    {
        $this->translationService = $translationService;
    }

    /**
     * Display the translation sync status page.
     */
    public function index(Request $request)
    {
        $locale = $request->get('locale', config('app.locale', 'en'));
        $locales = ['en', 'de'];

        // Get sync statistics for each locale
        $syncStats = [];
        foreach ($locales as $loc) {
            $syncStats[$loc] = $this->getSyncStatistics($loc);
        }

        // Get overall sync status
        $overallStatus = $this->getOverallSyncStatus();

        return view('admin.translations.index', compact('locales', 'locale', 'syncStats', 'overallStatus'));
    }

    /**
     * Get sync statistics for a specific locale.
     */
    protected function getSyncStatistics(string $locale): array
    {
        $totalItems = ContentItem::count();
        $translatableFields = ['title', 'description', 'prerequisites', 'instructor_name', 'instructor_bio', 'certification_details'];
        $expectedTranslations = $totalItems * count($translatableFields);

        // Count existing translations (with non-empty values) for this locale
        $existingTranslations = Translation::where('locale', $locale)
            ->where('translatable_type', ContentItem::class)
            ->whereNotNull('value')
            ->where('value', '!=', '')
            ->count();
        
        // Count total translation entries (including empty ones) for this locale
        $totalTranslationEntries = Translation::where('locale', $locale)
            ->where('translatable_type', ContentItem::class)
            ->count();

        // Count empty/missing translations
        $missingTranslations = $expectedTranslations - $existingTranslations;
        $syncPercentage = $expectedTranslations > 0 ? round(($existingTranslations / $expectedTranslations) * 100, 2) : 0;
        
        // Check if entries exist (even if empty) - means structure is synced
        $entriesSynced = $totalTranslationEntries >= $expectedTranslations;
        // Check if all translations are complete (all have values)
        $translationsComplete = $missingTranslations === 0 && $expectedTranslations > 0;

        return [
            'total_items' => $totalItems,
            'expected_translations' => $expectedTranslations,
            'existing_translations' => $existingTranslations,
            'missing_translations' => $missingTranslations,
            'total_entries' => $totalTranslationEntries,
            'entries_synced' => $entriesSynced,
            'sync_percentage' => $syncPercentage,
            'is_synced' => $entriesSynced && $translationsComplete,
        ];
    }

    /**
     * Get overall sync status across all locales.
     */
    protected function getOverallSyncStatus(): array
    {
        $totalItems = ContentItem::count();
        $locales = ['en', 'de'];
        $translatableFields = ['title', 'description', 'prerequisites', 'instructor_name', 'instructor_bio', 'certification_details'];
        $fieldsPerItem = count($translatableFields);

        $status = [
            'total_content_items' => $totalItems,
            'total_fields_per_item' => $fieldsPerItem,
            'locales' => [],
        ];

        foreach ($locales as $locale) {
            $stats = $this->getSyncStatistics($locale);
            $status['locales'][$locale] = $stats;
        }

        return $status;
    }

    /**
     * Update translations for a content item.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'locale' => 'required|string|in:en,de',
            'translations' => 'required|array',
        ]);

        $contentItem = ContentItem::findOrFail($id);
        $locale = $request->input('locale');
        $translations = $request->input('translations');

        $this->translationService->bulkUpdateTranslations($contentItem, $translations, $locale);

        return response()->json([
            'success' => true,
            'message' => 'Translations updated successfully.',
        ]);
    }

    /**
     * Get translations for a specific item.
     */
    public function show($id, Request $request)
    {
        $locale = $request->get('locale', app()->getLocale());
        $contentItem = ContentItem::findOrFail($id);

        $translations = Translation::where('translatable_type', ContentItem::class)
            ->where('translatable_id', $id)
            ->where('locale', $locale)
            ->pluck('value', 'field')
            ->toArray();

        return response()->json([
            'item' => $contentItem,
            'translations' => $translations,
            'locale' => $locale,
        ]);
    }

    /**
     * Sync translations for all content items (useful for existing data).
     */
    public function sync(Request $request)
    {
        $request->validate([
            'locale' => 'required|string|in:en,de',
        ]);

        $locale = $request->input('locale');
        $contentItems = ContentItem::all();
        $totalItems = $contentItems->count();
        $syncedCount = 0;
        $errors = [];

        try {
            DB::beginTransaction();

            foreach ($contentItems as $item) {
                try {
                    $this->translationService->syncTranslations($item, $locale);
                    $syncedCount++;
                } catch (\Exception $e) {
                    $errors[] = "Item ID {$item->id}: " . $e->getMessage();
                }
            }

            DB::commit();

            // Get updated statistics
            $stats = $this->getSyncStatistics($locale);
            $message = "✓ Sync Complete! Synced {$syncedCount} of {$totalItems} items for locale: " . strtoupper($locale) . ". ";
            $message .= "Total translations: {$stats['existing_translations']}/{$stats['expected_translations']} ({$stats['sync_percentage']}%)";

            if (!empty($errors)) {
                $message .= ". " . count($errors) . " errors occurred.";
            }

            if ($stats['is_synced']) {
                $message .= " ✓ All translations are in sync!";
            }

            return redirect()->route('admin.translations.index', ['locale' => $locale])
                ->with('success', $message)
                ->with('sync_stats', $stats);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.translations.index', ['locale' => $locale])
                ->with('error', "Sync failed: " . $e->getMessage());
        }
    }
}

