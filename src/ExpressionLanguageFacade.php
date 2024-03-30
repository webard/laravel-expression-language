<?php

namespace Webard\LaravelExpressionLanguage;

use Illuminate\Support\Facades\Facade;

class LaravelPackageSkeletonFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-expression-language';
    }
}
