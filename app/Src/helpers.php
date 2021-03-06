<?php

/**
 * @internal
 * Este archivo registra de forma global cualquier función que se quiera
 * utilizar a modo de helper en cualquier parte de la aplicación.
 */

declare(strict_types=1);

use Note\Src\Auth\Authenticator;

if (!function_exists('cleanUrl')) {
    /**
     * Limpia la URL de caracteres extraños.
     * @param string $url
     * @return string
     */
    function cleanUrl(string $url): string
    {
        return filter_var($url, FILTER_SANITIZE_URL);
    }
}

if (!function_exists('addExtension')) {
    /**
     * Agrega la extensión adecuada al archivo.
     * @param string $fileName
     * @param string $extension
     * @return string
     */
    function addExtension(string $fileName, string $extension): string
    {
        if (preg_match("/.{$extension}$/", $fileName)) {
            return $fileName;
        }
        return $fileName . ".{$extension}";
    }
}

if (!function_exists('normalizeName')) {
    /**
     * Normaliza la notación de punto a slash en el nombre de un template.
     * @param string $template
     * @param string $extension
     * @return string
     */
    function normalizeName(string $template, string $extension = null): string
    {
        return $extension ? str_replace('.', '/', $template) . ".{$extension}" : str_replace('.', '/', $template);
    }
}

if (!function_exists('getUrl')) {
    /**
     * Retorna la ruta completa de un recurso.
     * @param string $url
     * @return string
     */
    function getUrl(string $url): string
    {
        return URL . preg_replace('#^/#', '', $url);
    }
}

if (!function_exists('strong')) {
    /**
     * Resalta un patron de búsqueda en una cadena.
     * @deprecated
     * @param string $pattern
     * @param string $string
     * @return string
     */
    function strong(string $pattern, string $string): string
    {
        $pattern = preg_quote($pattern, '/');
        return preg_replace("/$pattern/iu", "<strong>$0</strong>", $string, 1);
    }
}

if (!function_exists('escapeLike')) {
    /**
     * Escapa caracteres 'wildcard' en sentencias LIKE de MySql.
     * @param string $string
     * @return string
     */
    function escapeLike(string $string): string
    {
        $search = ['\\', '%', '_'];
        $replace = ['\\\\\\', '\%', '\_'];
        return str_replace($search, $replace, $string);
    }
}

if (!function_exists('pdoType')) {
    /**
     * Resuelve el tipo de variable para el binding en PDO.
     * @param [type] $var
     * @param int $type valor por defecto.
     * @return int
     */
    function pdoType($var, $type = PDO::PARAM_STR): int
    {
        switch (gettype($var)) {
            case 'integer':
                $type = PDO::PARAM_INT;
                break;
            case 'string':
                $type = PDO::PARAM_STR;
                break;
            case 'boolean':
                $type = PDO::PARAM_BOOL;
                break;
            case 'NULL':
                $type = PDO::PARAM_NULL;
                break;
        }
        return $type;
    }
}

if (!function_exists('debug')) {
    /**
     * Interrumpe el flujo de la aplicación para poder depurar el código
     * mediante Psysh (solo funciona con el webserver de PHP).
     * @see https://psysh.org/
     * @return string
     */
    function debug(): string
    {
        define('STDIN', fopen('php://stdin', 'r'));
        return 'extract(\Psy\debug(get_defined_vars(), isset($this) ? $this : @get_called_class()));';
    }
}

/*
 * La idea de esta función es utilizarla en la definición de helpers para
 * construir objetos internos como Request, Response, no para construir
 * objetos en el modelo de dominio.
 */
if (!function_exists('container')) {
    /**
     * Retorna una instancia del contenedor IoC.
     * @param string|null $make nombre [class|interface] para construir una instancia.
     * @return \Illuminate\Container\Container|object
     * @throws \BadFunctionCallException
     */
    function container(string $make = null)
    {
        $c = \Illuminate\Container\Container::getInstance();
        if (is_null($c)) {
            throw new BadFunctionCallException("There is not yet a container configured");
        }
        return $make ? $c->make($make) : $c;
    }
}

if (!function_exists('session')) {
    /**
     * Retorna instancia del objeto Session.
     * @return \Symfony\Component\HttpFoundation\Session\Session
     */
    function session(): \Symfony\Component\HttpFoundation\Session\Session
    {
        return container(\Symfony\Component\HttpFoundation\Session\SessionInterface::class);
    }
}

if (!function_exists('csrf_field')) {
    /**
     * Retorna el campo de formulario para el token csrf.
     * @return string
     */
    function csrf_field(): string
    {
        return '<input type="hidden" name="_token" value="' . session()->get('_token') . '">';
    }
}

if (!function_exists('guest')) {
    /**
     * Valida si el usuario es invitado.
     * @return bool
     */
    function guest(): bool
    {
        return !session()->has(Authenticator::SESSION_AUTH);
    }
}

if (!function_exists('currentUser')) {
    /**
     * Retorna el usuario logueado actualmente en la aplicación.
     * @return \Note\Domain\User
     */
    function currentUser(): \Note\Domain\User
    {
        if (guest()) {
            throw new \RuntimeException("No user is currently signed in!");
        }
        return unserialize(session()->get(Authenticator::SESSION_AUTH));
    }
}

if (!function_exists('currentId')) {
    /**
     * Retorna el Id del usuario logueado actualmente en la aplicación.
     * @return int
     */
    function currentId(): int
    {
        return currentUser()->getId();
    }
}

if (!function_exists('request')) {
    /**
     * Retorna instancia del objeto Request.
     * @param string $input
     * @return \Illuminate\Http\Request|string|array
     */
    function request(string $input = null)
    {
        return $input ? container(\Illuminate\Http\Request::class)->input($input)
            : container(\Illuminate\Http\Request::class);
    }
}

if (!function_exists('route')) {
    /**
     * Genera una url a partir del nombre de una ruta.
     * @param string $name nombre de la ruta.
     * @param array $parameters parámetros que necesita la url.
     * @return string url.
     */
    function route(string $name, array $parameters = []): string
    {
        return container(\Illuminate\Routing\UrlGenerator::class)->route($name, $parameters);
    }
}

if (!function_exists('simpleFlash')) {
    /**
     * Permite agregar o resolver mensajes flash de sesión.
     * @param string|array $message mensaje.
     * @param string $type tipo de mensaje (success, info, warning, error).
     * @return \Tamtamchik\SimpleFlash\Flash|\Tamtamchik\SimpleFlash\Engine
     */
    function simpleFlash($message = '', string $type = 'info')
    {
        $flash = container(\Tamtamchik\SimpleFlash\Flash::class);
        if (!empty($message)) {
            return $flash->message($message, $type);
        }
        return $flash;
    }
}

if (!function_exists('view')) {
    /**
     * Compila un template y retorna instancia del objeto Response.
     * @param string $template nombre del template.
     * @param array $params parámetros a enviar al template.
     * @param int $status código de status http.
     * @return \Illuminate\Http\Response
     */
    function view(string $template, array $params = [], int $status = 200): \Illuminate\Http\Response
    {
        return container(\Note\Src\Response\View::class)->make($template, $params, $status);
    }
}

if (!function_exists('redirect')) {
    /**
     * Permite construir un Response tipo Redirect.
     * @param string $path
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    function redirect(string $path = null)
    {
        return $path ? container(\Illuminate\Routing\Redirector::class)->to($path)
            : container(\Illuminate\Routing\Redirector::class);
    }
}

if (!function_exists('abort')) {
    /**
     * Lanza una excepción del tipo HttpException.
     * @param int $statusCode código de estado http.
     * @param string $msg mensaje de estado http.
     * @param array $headers cabecera http.
     * @return void
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    function abort(int $statusCode = 404, string $msg = null, array $headers = []): void
    {
        throw new \Symfony\Component\HttpKernel\Exception\HttpException($statusCode, $msg, null, $headers, null);
    }
}
