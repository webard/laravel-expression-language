<?php

declare(strict_types=1);

namespace Webard\LaravelExpressionLanguage\Contracts;

interface ExpressionLanguage
{
    /**
     * @param  array<string,mixed>  $values
     */
    public function evaluate(string $expression, array $values): mixed;

    /**
     * @param  array<string>  $names
     */
    public function compile(string $expression, array $names): string;
}
