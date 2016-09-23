<?php

namespace Note\Domain;
use Note\Infrastructure\AuthorRepository;

class AuthorService extends Service
{
    /**
     * @param AuthorRepository $author instancia del repositorio de Author
     */
    public function __construct(AuthorRepository $author)
    {
        parent::__construct($author);
    }

    /**
     * @param string $userId id del usuario
     * @return \Illuminate\Support\Collection de Author
     */
    public function authors($userId)
    {
        return $this->entity->authors($userId);
    }
}
