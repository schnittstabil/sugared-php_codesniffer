<?php

namespace SugaredRim\PHP\CodeSniffer;

foreach ([
    __DIR__ . '/../vendor/squizlabs/php_codesniffer/autoload.php',
    __DIR__ . '/../../../autoload.php',
    __DIR__ . '/../../vendor/autoload.php',
    __DIR__ . '/../vendor/autoload.php'
] as $file) {
    if (file_exists($file)) {
        require $file;
        break;
    }
}

/*
 * PHPUnit 5/6
 */
if (!class_exists(\PHPUnit\Framework\TestCase::class)) {
    class_alias(\PHPUnit_Framework_TestCase::class, \PHPUnit\Framework\TestCase::class);
}
