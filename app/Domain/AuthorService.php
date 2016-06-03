<?php

namespace Note\Domain;
use Note\Infrastructure\AuthorRepository;

class AuthorService
{
    /**
     * @var AuthorRepository
     */
    private $authors;

    /**
     * @param AuthorRepository $authors
     */
    public function __construct(AuthorRepository $authors)
    {
        $this->authors = $authors;
    }

    /**
     * @param $id
     * @return Author
     */
    public function find($id)
    {
        return $this->authors->findAuthor($id);
    }

    /**
     * @param $userId
     * @return \Illuminate\Support\Collection
     */
    public function listAuthors($userId)
    {
        return $this->authors->listUserAuthors($userId);
    }
}