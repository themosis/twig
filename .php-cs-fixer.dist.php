<?php

$finder = PhpCsFixer\Finder::create()
    ->in([
        'src',
        'tests',
    ])
    ->exclude([
        'tests/cache',
        'tests/views',
    ]);

$config = new PhpCsFixer\Config();

return $config->setRules([
    '@PSR12' => true,
    'array_syntax' => ['syntax' => 'short'],
])
    ->setFinder($finder);