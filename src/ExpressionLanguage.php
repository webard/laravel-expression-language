<?php

declare(strict_types=1);

namespace Webard\LaravelExpressionLanguage;

use Illuminate\Config\Repository;
use Illuminate\Support\Traits\ForwardsCalls;
use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage as SymfonyExpressionLanguage;

/**
 * @mixin SymfonyExpressionLanguage
 */
final class ExpressionLanguage
{
    use ForwardsCalls;

    public readonly SymfonyExpressionLanguage $expressionLanguage;

    public function __construct(private Repository $config)
    {
        $functionsProvider = new class($this->getExpressionFunctions()) implements ExpressionFunctionProviderInterface
        {
            public function __construct(private array $expressionFunctions)
            {
            }

            public function getFunctions(): array
            {
                return $this->expressionFunctions;
            }
        };

        $this->expressionLanguage = new SymfonyExpressionLanguage(null, [$functionsProvider]);
    }

    private function getExpressionFunctions(): array
    {
        $allowedFunctions = $this->config->get('expression-language.allowed_functions', []);

        return array_map(
            function (string|array $functionName) {
                $functionName = is_array($functionName) ? $functionName : [$functionName];

                return ExpressionFunction::fromPhp(...$functionName);
            },
            $allowedFunctions
        );
    }

    public function __call(string $name, array $arguments): mixed
    {
        return $this->forwardCallTo($this->expressionLanguage, $name, $arguments);
    }
}
