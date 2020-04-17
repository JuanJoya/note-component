<?php

/**
 * Una aplicación generalmente tiene varios entornos (desarrollo, producción), cada entorno
 * maneja diferentes credenciales para autenticar servicios o conectar bases de datos, estas
 * credenciales no deben estar definidas enl el código no solo por el problema que genera cambiar
 * de entorno sino por que son información sensible y un error en el servidor puede exponer estos
 * datos al usuario final.
 * La solución es utilizar variables de entorno.
 * @see https://www.12factor.net/config
 */

declare(strict_types=1);

/**
 * En desarrollo se suele utilizar un archivo [.env] para guardar las credenciales, luego se utiliza
 * un Dotenv Parser para leer el archivo y setear cada credencial como una variable de entorno.
 * @see https://github.com/josegonzalez/php-dotenv#usage
 */
use josegonzalez\Dotenv\Loader;

/**
 * En producción se deben establecer variables de entorno 'reales' para evitar
 * la ejecución del Dotenv Parser en cada Request.
 */
if (!getenv('APP_NAME')) {
    Loader::load([
        'filepath' => ROOT_PATH . '/.env',
        'expect'   => array('APP_DEBUG'),
        'toEnv'    => true,
        'toServer' => true,
        'putenv'   => true
    ]);
}
