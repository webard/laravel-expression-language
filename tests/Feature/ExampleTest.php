<?php

use Illuminate\Support\Facades\Validator;
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

test('validation fails', function () {
    $data = [
        'expression' => '1.25) + 1',
    ];

    $validator = Validator::make($data, [
        'expression' => new \Webard\LaravelExpressionLanguage\Rules\ExpressionRule(),
    ]);

    expect($validator->fails())->toBeTrue();
});

test('validation pass', function () {
    $data = [
        'expression' => 'floor(1.25) + 1',
    ];

    $validator = Validator::make($data, [
        'expression' => new \Webard\LaravelExpressionLanguage\Rules\ExpressionRule(),
    ]);

    expect($validator->passes())->toBeTrue();
});
