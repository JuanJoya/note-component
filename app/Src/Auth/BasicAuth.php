<?php

declare(strict_types=1);

namespace Note\Src\Auth;

use Tamtamchik\SimpleFlash\Flash;
use Note\Domain\Services\User\UserService;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Esta clase permite gestionar el tema de la autenticación de usuarios.
 */
class BasicAuth implements Authenticator
{
    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var UserService
     */
    private $users;

    /**
     * @var Flash
     */
    private $flash;

    /**
     * @param SessionInterface $session
     * @param UserService $users
     * @param Flash $flash
     */
    public function __construct(SessionInterface $session, UserService $users, Flash $flash)
    {
        $this->session = $session;
        $this->users = $users;
        $this->flash = $flash;
    }

    /**
     * {@inheritdoc}
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function login(string $email, string $password): bool
    {
        $user = $this->users->find($email, 'email');
        if ($user) {
            if (password_verify($password, $user->getPassword())) {
                $this->session->migrate();
                $this->session->set(self::SESSION_AUTH, $user->getId());
                $this->flash->message('Welcome back!');
                return true;
            }
        }
        return false;
    }

    /**
     * {@inheritdoc}
     * @return void
     */
    public function logout(): void
    {
        $this->session->remove(self::SESSION_AUTH);
    }

    /**
     * {@inheritdoc}
     * @param array $data
     * @return boolean
     */
    public function register(array $data): bool
    {
        $user = $this->users->create($data);
        if ($user) {
            $this->session->migrate();
            $this->session->set(self::SESSION_AUTH, $user->getId());
            $this->flash->message('Registration successful!');
            return true;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     * @return bool
     */
    public function check(): bool
    {
        return $this->session->has(self::SESSION_AUTH);
    }

    /**
     * {@inheritdoc}
     * @return bool
     */
    public function guest(): bool
    {
        return !$this->session->has(self::SESSION_AUTH);
    }
}
