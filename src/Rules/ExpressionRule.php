<?php

declare(strict_types=1);

namespace Webard\LaravelExpressionLanguage\Rules;

use App\Contracts\ExpressionLanguageContract;
use App\Services\ExpressionLanguage;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Throwable;

final class ExpressionRule implements ValidationRule
{
    private ExpressionLanguage $expressionLanguage;

    /**
     * @var array<string, mixed>
     */
    private array $variables = [];

    public function __construct()
    {
        $this->expressionLanguage = app()->make(ExpressionLanguageContract::class);
    }

    /**
     * @param  array<string>  $variables
     */
    public function availableVariables(array $variables): self
    {
        $this->variables = $variables;

        return $this;
    }

    /**
     * Run the validation rule.
     *
     * @param  Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            $this->expressionLanguage->compile($value, $this->variables);
        } catch (Throwable $e) {
            $fail($e->getMessage());
        }
    }
}
