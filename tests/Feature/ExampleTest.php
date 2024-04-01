<?php

use Symfony\Component\ExpressionLanguage\SyntaxError;
use Webard\LaravelExpressionLanguage\Facade\ExpressionLanguage as FacadeExpressionLanguage;

test('evaluate', function () {
    $result = FacadeExpressionLanguage::evaluate('floor(1.25) + 1', []);

    expect($result)->toBe(2.0);
});

test('compile', function () {
    $result = FacadeExpressionLanguage::compile('2/1 + 1', []);

    expect($result)->toBe('((2 / 1) + 1)');
});

it('throws exception when disabled function', function () {
    FacadeExpressionLanguage::evaluate('eval(1.25) + 1', []);
})->throws(SyntaxError::class);
