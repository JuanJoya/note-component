<?php

/**
 * Este script configura el error handler de la aplicación.
 * @see https://github.com/filp/whoops
 */

declare(strict_types=1);

use Whoops\{Handler\PrettyPageHandler, Run as ErrorHandler};
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\Response;
use Note\Src\Response\Html;

/**
 * Permite deshabilitar cualquier error|exception output.
 */
ini_set('display_errors', getenv('APP_DEBUG') ? 'on' : 'off');

$whoops = new ErrorHandler();

/**
 * Se verifica con la variable de entorno [APP_DEBUG] si la aplicación esta en
 * modo (true)Desarrollo o (false|null)Producción.
 */
if (getenv('APP_DEBUG')) {
    /**
     * PrettyPageHandler permite ver en detalle cualquier excepción|error de la aplicación.
     */
    $whoops->pushHandler(new PrettyPageHandler());
} else {
    /**
     * Se crea un Response teniendo en cuenta el tipo de excepción|error.
     */
    $whoops->pushHandler(function ($e) {
        if ($e instanceof HttpException) {
            $code = $e->getStatusCode();
            Html::error($code, ['status' => $code, 'message' => Response::$statusTexts[$code]])->send();
        } else {
            Html::error(500, ['status' => 500, 'message' => 'Internal Server Error'])->send();
        }
    });
}

/**
 * Se registra la instancia como error handler de la aplicación.
 */
$whoops->register();
