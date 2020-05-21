<?php

/**
 * Este archivo configura aspectos básicos del sistema de validación,
 * se pueden registrar nuevas reglas de validación.
 */

declare(strict_types=1);

use Sirius\Validation\RuleFactory;
use Note\Src\Validation\Rule\{Unique, Exists, Image, Size};

/**
 * El método 'register' en el objeto RuleFactory permite registrar una clase
 * que herede de AbstractRule para ser utilizada como regla de validación.
 * @var \Illuminate\Container\Container $container
 */
$container->bind(RuleFactory::class, function () {
    $ruleFactory = new RuleFactory();
    $ruleFactory->register('unique', Unique::class);
    $ruleFactory->register('exists', Exists::class);
    $ruleFactory->register('image', Image::class);
    $ruleFactory->register('size', Size::class);
    return $ruleFactory;
});
