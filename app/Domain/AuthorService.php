<?php

namespace Note\Domain;

use Note\Infrastructure\AuthorRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AuthorService extends Service
{
    /**
     * @param AuthorRepository $author instancia del repositorio de Author
     */
    public function __construct(AuthorRepository $author)
    {
        $this->entity = $author;
    }

    /**
     * @param User $user
     * @return \Illuminate\Support\Collection de Author
     */
    public function authors(User $user)
    {
        if(empty($user->getId())) {
            throw new \InvalidArgumentException("Empty user id");
        }

        return $this->entity->authors($user->getId());
    }

    /**
     * @param Author $author
     * @param User $user Auth
     */
    public function validateAuthor(Author $author, User $user)
    {
        if ($author->getId() != $user->getId()) {
            throw new NotFoundHttpException();
        }
    }
}
