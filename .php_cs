<?php


$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->in('spec')
    ->in('src')
    ->in('tests')
    ->notName('*.xml');

return Symfony\CS\Config\Config::create()
    ->setUsingCache(true)
    ->level(\Symfony\CS\FixerInterface::SYMFONY_LEVEL)
    ->fixers([
        'short_array_syntax',
        'align_double_arrow',
        'align_equals',
        'no_blank_lines_before_namespace',
        'ordered_use',
        'phpdoc_order',
    ])
    ->finder($finder);
