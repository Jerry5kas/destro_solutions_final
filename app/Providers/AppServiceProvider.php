<?php

namespace App\Providers;

use App\Models\ContentItem;
use App\Observers\ContentItemObserver;
use App\Services\MachineTranslation\Contracts\TranslationProviderInterface;
use App\Services\MachineTranslation\MachineTranslationService;
use App\Services\MachineTranslation\Providers\DeepLTranslationProvider;
use App\Services\MachineTranslation\Providers\NullTranslationProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(TranslationProviderInterface::class, function () {
            $config = config('services.translation');
            $provider = $config['provider'] ?? 'null';

            return match ($provider) {
                'deepl' => new DeepLTranslationProvider(
                    $config['deepl']['api_key'] ?? '',
                    $config['deepl']['base_url'] ?? 'https://api-free.deepl.com'
                ),
                default => new NullTranslationProvider(),
            };
        });

        $this->app->singleton(MachineTranslationService::class, function ($app) {
            return new MachineTranslationService(
                $app->make(TranslationProviderInterface::class)
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register ContentItem Observer for automatic translation syncing
        ContentItem::observe(ContentItemObserver::class);
    }
}
