<?php

declare(strict_types=1);

namespace Webard\LaravelExpressionLanguage;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

final class ServiceProvider extends LaravelServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bindIf(
            'expression-language',
            function () {
                return $this->app->make(ExpressionLanguage::class);
            },
            true

        );

    }

    protected function loadConfiguration(): void
    {
        $configPath = __DIR__.'/../config/config.php';

        $this->publishes([$configPath => config_path('expression-language.php')], 'config');

        $this->mergeConfigFrom($configPath, 'expression-language');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadConfiguration();
    }
}
