<?php

declare(strict_types=1);

namespace Note\Domain;

use Note\Domain\Traits\Timestamps;

class Author
{
    use Timestamps;

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
     * @param string $slug
     * @param string $created_at
     * @param string $updated_at
     * @param int $id
     */
    public function __construct(
        User $user,
        string $username,
        string $slug,
        string $created_at,
        string $updated_at,
        int $id
    ) {
        $this->user = $user;
        $this->username = $username;
        $this->slug = $slug;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
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
