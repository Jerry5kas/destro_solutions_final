<?php

namespace App\Observers;

use App\Jobs\AutoTranslateContentItem;
use App\Models\ContentItem;
use App\Services\TranslationService;

class ContentItemObserver
{
    protected TranslationService $translationService;

    public function __construct(TranslationService $translationService)
    {
        $this->translationService = $translationService;
    }

    /**
     * Handle the ContentItem "created" event.
     */
    public function created(ContentItem $contentItem): void
    {
        $this->translationService->syncTranslations($contentItem);
        $this->dispatchAutoTranslation($contentItem);
    }

    /**
     * Handle the ContentItem "updated" event.
     */
    public function updated(ContentItem $contentItem): void
    {
        // Only sync if translatable fields changed
        $translatableFields = $contentItem->getTranslatableFields();
        $changedFields = array_intersect($translatableFields, array_keys($contentItem->getChanges()));

        if (!empty($changedFields)) {
            $this->translationService->syncTranslations($contentItem);
            $this->dispatchAutoTranslation($contentItem);
        }
    }

    /**
     * Handle the ContentItem "deleted" event.
     */
    public function deleted(ContentItem $contentItem): void
    {
        $this->translationService->deleteTranslations($contentItem);
    }

    protected function dispatchAutoTranslation(ContentItem $contentItem): void
    {
        if (!config('translation.auto_translate', false)) {
            return;
        }

        $targetLocales = array_filter(config('translation.target_locales', []));

        if (empty($targetLocales)) {
            return;
        }

        AutoTranslateContentItem::dispatch($contentItem->id, $targetLocales);
    }
}

