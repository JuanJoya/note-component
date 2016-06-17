<?php

namespace Note\Domain;
use Note\Infrastructure\AuthorRepository;

class AuthorService extends Service
{
    /**
     * @param AuthorRepository $authors
     */
    public function __construct(AuthorRepository $authors)
    {
        parent::__construct($authors);
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function authors($userId)
    {
        return $this->entity->authors($userId);
    }
}