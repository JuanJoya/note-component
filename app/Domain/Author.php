<?php

declare(strict_types=1);

namespace Note\Domain;

class Author
{
    /**
     * @var User usuario creador del autor.
     */
    private $user;

    /**
     * @var string seudónimo de un autor.
     */
    private $username;

    /**
     * @var string slug formado por el seudónimo.
     */
    private $slug;

    /**
     * @var int id identificador de un autor.
     */
    private $id;

    /**
     * @param User $user
     * @param string $username
     * @param int $id
     */
    public function __construct(User $user, string $username, string $slug, int $id)
    {
        $this->user = $user;
        $this->username = $username;
        $this->slug = $slug;
        $this->id = $id;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
