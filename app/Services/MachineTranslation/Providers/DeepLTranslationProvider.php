<?php

namespace App\Services\MachineTranslation\Providers;

use App\Services\MachineTranslation\Contracts\TranslationProviderInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class DeepLTranslationProvider implements TranslationProviderInterface
{
    protected string $apiKey;
    protected string $baseUrl;

    public function __construct(string $apiKey, string $baseUrl)
    {
        $this->apiKey = $apiKey;
        $this->baseUrl = rtrim($baseUrl, '/');
    }

    public function translate(array $payload, string $sourceLocale, string $targetLocale): array
    {
        if (!$this->isEnabled() || empty($payload)) {
            return $payload;
        }

        $response = Http::asForm()->post(
            "{$this->baseUrl}/v2/translate",
            $this->buildRequestBody(array_values($payload), $sourceLocale, $targetLocale)
        );

        if ($response->failed()) {
            report(new \RuntimeException(
                'DeepL translation failed: '.$response->body()
            ));

            return $payload;
        }

        $translated = $response->json('translations', []);
        $results = [];

        foreach (array_keys($payload) as $index => $field) {
            $results[$field] = $translated[$index]['text'] ?? $payload[$field];
        }

        return $results;
    }

    protected function buildRequestBody(array $texts, string $sourceLocale, string $targetLocale): array
    {
        $body = [
            'auth_key' => $this->apiKey,
            'text' => $texts,
            'target_lang' => Str::upper($targetLocale),
        ];

        if ($sourceLocale) {
            $body['source_lang'] = Str::upper($sourceLocale);
        }

        return $body;
    }

    public function isEnabled(): bool
    {
        return !empty($this->apiKey);
    }
}

