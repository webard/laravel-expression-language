<?php

declare(strict_types=1);

namespace Webard\LaravelExpressionLanguage;

use Illuminate\Config\Repository;
use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage as SymfonyExpressionLanguage;

final class ExpressionLanguage
{
    public readonly SymfonyExpressionLanguage $expressionLanguage;

    public function __construct(private Repository $config)
    {
        $allowedFunctions = $this->config->get('expression-language.allowed_functions', []);

        $expressionFunctions = array_map(
            function (string|array $functionName) {
                $functionName = is_array($functionName) ? $functionName : [$functionName];

                return ExpressionFunction::fromPhp(...$functionName);
            },
            $allowedFunctions
        );
        $functionsProvider = new class($expressionFunctions) implements ExpressionFunctionProviderInterface
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

    /**
     * Evaluates an expression.
     *
     * @param  array<string,mixed>  $values
     */
    public function evaluate(string $expression, array $values): mixed
    {
        return $this->expressionLanguage->evaluate($expression, $values);
    }

    /**
     * Compiles an expression source code.
     *
     * @param  array<string>  $names
     */
    public function compile(string $expression, array $names): string
    {
        return $this->expressionLanguage->compile($expression, $names);
    }
}
