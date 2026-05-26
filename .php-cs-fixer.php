<?php

$finder = PhpCsFixer\Finder::create()
    ->in([__DIR__ . '/src', __DIR__ . '/controllers'])
    ->name('*.php');

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12'                         => true,
        'array_syntax'                   => ['syntax' => 'short'],
        'ordered_imports'                => ['sort_algorithm' => 'alpha'],
        'no_unused_imports'              => true,
        'trailing_comma_in_multiline'    => true,
        'phpdoc_scalar'                  => true,
        'unary_operator_spaces'          => true,
        'binary_operator_spaces'         => true,
        'blank_line_before_statement'    => ['statements' => ['return']],
        'single_quote'                   => true,
        'no_extra_blank_lines'           => true,
        'no_whitespace_in_blank_line'    => true,
    ])
    ->setFinder($finder)
    ->setCacheFile(__DIR__ . '/.php-cs-fixer.cache');
