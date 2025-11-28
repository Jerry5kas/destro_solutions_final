<?php

namespace App\Services\MachineTranslation;

use App\Services\MachineTranslation\Contracts\TranslationProviderInterface;

class MachineTranslationService
{
    protected TranslationProviderInterface $provider;

    public function __construct(TranslationProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Translate an associative array of field => text pairs.
     *
     * @param  array<string, string>  $payload
     * @return array<string, string>
     */
    public function translate(array $payload, string $sourceLocale, string $targetLocale): array
    {
        return $this->provider->translate($payload, $sourceLocale, $targetLocale);
    }

    public function isEnabled(): bool
    {
        return $this->provider->isEnabled();
    }
}

