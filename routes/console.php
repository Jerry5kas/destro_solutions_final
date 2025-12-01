<?php

use App\Jobs\AutoTranslateContentItem;
use App\Models\ContentItem;
use App\Services\MachineTranslation\MachineTranslationService;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('translations:auto-fill {locale?} {--sync}', function (?string $locale = null) {
    /** @var MachineTranslationService $machineTranslationService */
    $machineTranslationService = app(MachineTranslationService::class);

    if (!$machineTranslationService->isEnabled()) {
        $this->error('Machine translation service is not configured. Please set credentials first.');
        return;
    }

    $targetLocales = array_filter(config('translation.target_locales', []));
    $locale = $locale ?? ($targetLocales[0] ?? null);

    if (!$locale) {
        $this->error('No locale provided and no default target locale configured.');
        return;
    }

    $this->info("Auto-translating content items for locale: {$locale}");

    $count = 0;
    ContentItem::chunkById(50, function ($items) use (&$count, $locale) {
        foreach ($items as $item) {
            if ($this->option('sync')) {
                AutoTranslateContentItem::dispatchSync($item->id, [$locale]);
            } else {
                AutoTranslateContentItem::dispatch($item->id, [$locale]);
            }
            $count++;
        }
    });

    $this->info("Queued translation jobs for {$count} content items.");
})->purpose('Auto translate all content items for a locale');
