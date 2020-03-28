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
     * @var int
     */
    private $id;

    /**
     * @param string $email
     * @param string $pass
     * @param int $id
     */
    public function __construct(string $email, int $id, string $password = null)
    {
        $this->email = $email;
        $this->id = $id;
        $this->password = $password;
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
}
