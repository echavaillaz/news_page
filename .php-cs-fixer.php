<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

if (PHP_SAPI !== 'cli') {
    die('This script supports command line usage only. Please check your command.');
}

return (new Config())
    ->setFinder(Finder::create()->in(__DIR__))
    ->setRiskyAllowed(true)
    ->setRules([
        '@DoctrineAnnotation' => true,
        '@PSR12' => true,
        'array_syntax' => [
            'syntax' => 'short'
        ],
        'cast_spaces' => [
            'space' => 'none'
        ],
        'concat_space' => [
            'spacing' => 'one'
        ],
        'dir_constant' => true,
        'function_typehint_space' => true,
        'modernize_types_casting' => true,
        'native_function_casing' => true,
        'no_alias_functions' => true,
        'no_blank_lines_after_phpdoc' => true,
        'no_empty_phpdoc' => true,
        'no_empty_statement' => true,
        'no_extra_blank_lines' => true,
        'no_leading_namespace_whitespace' => true,
        'no_null_property_initialization' => true,
        'no_short_bool_cast' => true,
        'no_singleline_whitespace_before_semicolons' => true,
        'no_superfluous_elseif' => true,
        'no_trailing_comma_in_singleline_array' => true,
        'no_unneeded_control_parentheses' => true,
        'no_unused_imports' => true,
        'no_useless_else' => true,
        'phpdoc_no_access' => true,
        'phpdoc_no_empty_return' => true,
        'phpdoc_no_package' => true,
        'phpdoc_scalar' => true,
        'phpdoc_trim' => true,
        'phpdoc_types' => true,
        'phpdoc_types_order' => [
            'null_adjustment' => 'always_last',
            'sort_algorithm' => 'none'
        ],
        'single_quote' => true,
        'single_line_comment_style' => [
            'comment_types' => [
                'hash'
            ]
        ],
        'static_lambda' => true,
        'whitespace_after_comma_in_array' => true
    ]);
