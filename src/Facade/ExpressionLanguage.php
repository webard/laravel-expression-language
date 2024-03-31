<?php

namespace Webard\LaravelExpressionLanguage\Facade;

use Illuminate\Support\Facades\Facade;

class ExpressionLanguage extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'expression-language';
    }
}
