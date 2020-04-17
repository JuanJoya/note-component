<?php

declare(strict_types=1);

namespace Note\Src\Template\Twig;

use Twig\TwigFunction as Func;
use Twig\Extension\AbstractExtension;

/**
 * Esta clase permite el registro de funciones, filtros, tags, objetos,
 * para que estén disponibles en los templates.
 * @see https://twig.symfony.com/doc/3.x/advanced.html#creating-an-extension
 */
class TwigExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new Func('url', 'getUrl'),
            new Func('request', 'request'),
            new Func('route', 'route'),
            new Func('flash', 'simpleFlash'),
            new Func('guest', 'guest'),
            new Func('csrf_field', 'csrf_field')
        ];
    }
}
