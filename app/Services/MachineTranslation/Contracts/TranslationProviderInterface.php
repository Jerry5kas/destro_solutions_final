<?php

namespace App\Services\MachineTranslation\Contracts;

interface TranslationProviderInterface
{
    /**
     * Translate an array of strings.
     *
     * @param  array<string, string>  $payload
     * @return array<string, string>
     */
    public function translate(array $payload, string $sourceLocale, string $targetLocale): array;

    /**
     * Determine if the provider is ready to make API calls.
     */
    public function isEnabled(): bool;
}

