<?php

declare(strict_types=1);

namespace Note\Src\Auth;

abstract class Auth
{
    /**
     * @var string nombre de la sesión.
     */
    protected const SESSION_AUTH = 'user_id';

    /**
     * Evaluá si el usuario inicio sesión en la aplicación.
     * @return bool
     */
    public static function check(): bool
    {
        return session()->has(self::SESSION_AUTH);
    }

    /**
     * Evaluá si el usuario no ha iniciado sesión en la aplicación.
     * @return bool
     */
    public static function guest(): bool
    {
        return !session()->has(self::SESSION_AUTH);
    }
}
