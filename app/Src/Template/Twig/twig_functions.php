<?php

/**
 * Este archivo permite el registro de funciones, filtros, tags, objetos,
 * para que estén disponibles en los templates.
 * @see https://twig.symfony.com/doc/2.x/advanced.html
 * @var \Twig\Environment $env
 */

declare(strict_types=1);

use Twig\TwigFunction;

$env->addFunction(
    new TwigFunction('url', 'getUrl')
);

$env->addFunction(
    new TwigFunction('request', 'request')
);

$env->addFunction(
    new TwigFunction('route', 'route')
);

$env->addFunction(
    new TwigFunction('flash', 'simpleFlash')
);

$env->addFunction(
    new TwigFunction('guest', 'guest')
);

$env->addFunction(
    new TwigFunction('csrf_field', 'csrf_field')
);
