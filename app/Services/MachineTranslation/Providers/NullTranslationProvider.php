<?php

namespace App\Services\MachineTranslation\Providers;

use App\Services\MachineTranslation\Contracts\TranslationProviderInterface;

class NullTranslationProvider implements TranslationProviderInterface
{
    public function translate(array $payload, string $sourceLocale, string $targetLocale): array
    {
        // Return original text when no provider is configured.
        return $payload;
    }

    public function isEnabled(): bool
    {
        return false;
    }
}

