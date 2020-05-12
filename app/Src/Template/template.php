<?php

/**
 * Este archivo configura aspectos básicos del Template Engine, desde
 * aquí se puede cambiar la implementación de la interface.
 */

declare(strict_types=1);

use Note\Src\Template\{TemplateEngine, Twig\Twig};
use Twig\Loader\{FilesystemLoader, LoaderInterface};

/**
 * El método 'bind' le indica al contenedor, el contrato y la implementación
 * esto permite añadir una interface como parámetro|dependencia.
 * @var \Illuminate\Container\Container $container
 */
$container->bind(TemplateEngine::class, Twig::class);

/**
 * El método 'bind' no se limita a resolver interfaces, es de utilidad para
 * enseñarle al contenedor como resolver un objeto concreto que necesita
 * cierta preparación.
 */
$container->bind(LoaderInterface::class, function ($container) {
    return new FilesystemLoader(ROOT_PATH . '/resources/views');
});
