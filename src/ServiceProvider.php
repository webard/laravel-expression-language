<?php

declare(strict_types=1);

namespace Webard\LaravelExpressionLanguage;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Symfony\Component\ExpressionLanguage\ExpressionFunction;

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
                $allowedFunctions = $this->app['config']->get('expression-language.allowed_functions');

                $expressionFunctions = array_map(
                    function (string|array $functionName) {
                        $functionName = is_array($functionName) ? $functionName : [$functionName];

                        return ExpressionFunction::fromPhp(...$functionName);
                    },
                    $allowedFunctions
                );

                return new ExpressionLanguage($expressionFunctions);
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
