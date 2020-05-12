<?php

declare(strict_types=1);

namespace Note\Src\Auth;

use Note\Domain\User;

interface Authenticator
{
    /**
     * @var string nombre de la sesión.
     */
    public const SESSION_AUTH = 'user_id';

    /**
     * Permite iniciar sesión en la aplicación, se crea una
     * variable de sesión con el identificador único del usuario.
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function login(string $email, string $password): bool;

    /**
     * Elimina el identificador único del usuario en la
     * variable de sesión.
     * @return void
     */
    public function logout(): void;

    /**
     * Permite registrar usuarios en la aplicación.
     * @param array $data información necesaria para crear un usuario.
     * @return bool
     */
    public function register(array $data): bool;

    /**
     * Evaluá si el usuario inicio sesión en la aplicación.
     * @return bool
     */
    public function check(): bool;

    /**
     * Evaluá si el usuario no ha iniciado sesión en la aplicación.
     * @return bool
     */
    public function guest(): bool;

    /**
     * Retorna el usuario logueado actualmente en la aplicación.
     * @return User
     */
    public function user(): User;
}
