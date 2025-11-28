<?php

namespace App\Jobs;

use App\Models\ContentItem;
use App\Services\MachineTranslation\MachineTranslationService;
use App\Services\TranslationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AutoTranslateContentItem implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @param  array<int, string>  $locales
     */
    public function __construct(
        public int $contentItemId,
        public array $locales
    ) {
    }

    public function handle(
        TranslationService $translationService,
        MachineTranslationService $machineTranslationService
    ): void {
        $contentItem = ContentItem::find($this->contentItemId);

        if (!$contentItem || !$machineTranslationService->isEnabled()) {
            return;
        }

        $fields = $contentItem->getTranslatableFields();
        $sourceLocale = config('translation.source_locale', 'en');

        foreach ($this->locales as $locale) {
            if ($locale === $sourceLocale) {
                continue;
            }

            $payload = [];

            foreach ($fields as $field) {
                $value = $contentItem->getAttribute($field);
                if (!is_string($value)) {
                    $value = is_array($value) ? json_encode($value) : (string) $value;
                }

                if (trim((string) $value) === '') {
                    continue;
                }

                $payload[$field] = $value;
            }

            if (empty($payload)) {
                continue;
            }

            $translations = $machineTranslationService->translate($payload, $sourceLocale, $locale);

            $translationService->bulkUpdateTranslations(
                $contentItem,
                $translations,
                $locale,
                isAuto: true
            );
        }
    }
}

