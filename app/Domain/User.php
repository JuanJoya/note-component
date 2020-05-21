<?php

declare(strict_types=1);

namespace Note\Domain;

class User
{
    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $avatar;

    /**
     * @var int
     */
    private $id;

    /**
     * @param string $email
     * @param int $id
     * @param string $password
     * @param string $avatar
     */
    public function __construct(string $email, int $id, string $password = null, string $avatar = null)
    {
        $this->email = $email;
        $this->id = $id;
        $this->password = $password;
        $this->avatar = $avatar;
    }

    /**
     * @param string $email
     * @return void
     */
    public function setEmail(string $email): void
    {
        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException(
                "Invalid email address: [$email]"
            );
        }
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $pass
     * @return void
     */
    public function setPassword(string $password): void
    {
        if (empty($password)) {
            throw new \InvalidArgumentException(
                "Empty password"
            );
        }
        $this->password = $password;
    }

    /**
     * @return string password-hash
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return substr($this->getId() . '#' . $this->getEmail(), 0, 15);
    }

    /**
     * Nombre del fichero.
     * @return string
     */
    public function getAvatar(): string
    {
        if (!$this->avatar) {
            return "default-avatar.jpg";
        }
        return $this->avatar;
    }

    /**
     * Propiedades del objeto a serializar.
     * @return array
     */
    public function __sleep(): array
    {
        return ['email', 'id', 'avatar'];
    }
}
