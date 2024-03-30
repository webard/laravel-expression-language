<?php

declare(strict_types=1);

namespace Webard\LaravelExpressionLanguage;

use Illuminate\Support\ServiceProvider;
use Symfony\Component\ExpressionLanguage\ExpressionFunction;

final class ExpressionLanguageProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            ExpressionLanguage::class,
            fn () => new ExpressionLanguage(
                [
                    ExpressionFunction::fromPhp('ceil'),
                    ExpressionFunction::fromPhp('floor'),
                    ExpressionFunction::fromPhp('round'),
                    ExpressionFunction::fromPhp('min'),
                    ExpressionFunction::fromPhp('max'),
                    ExpressionFunction::fromPhp('abs'),
                    ExpressionFunction::fromPhp('pow'),
                    ExpressionFunction::fromPhp('sqrt'),
                    ExpressionFunction::fromPhp('log'),
                    ExpressionFunction::fromPhp('exp'),
                    ExpressionFunction::fromPhp('sin'),
                    ExpressionFunction::fromPhp('cos'),
                    ExpressionFunction::fromPhp('tan'),
                    ExpressionFunction::fromPhp('asin'),
                    ExpressionFunction::fromPhp('acos'),
                    ExpressionFunction::fromPhp('atan'),
                    ExpressionFunction::fromPhp('atan2'),
                ]
            )
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
    }
}
