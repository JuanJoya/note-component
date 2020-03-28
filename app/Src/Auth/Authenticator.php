<?php

declare(strict_types=1);

namespace Note\Src\Auth;

interface Authenticator
{
    /**
     * Este método permite iniciar sesión en la aplicación, se crea una
     * variable de sesión con el identificador único del usuario.
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function login(string $email, string $password): bool;

    /**
     * Este método elimina el identificador único del usuario en la
     * variable de sesión.
     * @return void
     */
    public function logout(): void;

    /**
     * Este método permite registrar usuarios en la aplicación.
     * @param array $data información necesaria para crear un usuario.
     * @return bool
     */
    public function register(array $data): bool;
}
