<?php

declare(strict_types=1);

namespace Webard\LaravelExpressionLanguage;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage as SymfonyExpressionLanguage;

final class ExpressionLanguage
{
    private SymfonyExpressionLanguage $expressionLanguage;

    /**
     * @param  array<ExpressionFunction>  $functions
     */
    public function __construct(array $functions = [])
    {

        $functionsProvider = new class($functions) implements ExpressionFunctionProviderInterface
        {
            /**
             * @param  array<ExpressionFunction>  $functions
             */
            public function __construct(private array $functions)
            {
            }

            public function getFunctions(): array
            {
                return $this->functions;
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
