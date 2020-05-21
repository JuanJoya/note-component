<?php

declare(strict_types=1);

namespace Note\Domain\Services\Author;

use Note\Domain\Author;
use Illuminate\Support\Collection;
use Note\Domain\Services\BaseService;
use Note\Infrastructure\AuthorRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AuthorServiceBasic extends BaseService implements AuthorService
{
    /**
     * @var AuthorRepository
     */
    private $author;

    /**
     * @param AuthorRepository $author
     */
    public function __construct(AuthorRepository $author)
    {
        $this->author = $author;
    }

    /**
     * @param int $user_id
     * @param bool $plain
     * @return Collection
     */
    public function byUser(int $user_id, bool $plain = false): Collection
    {
        return $this->repository()->authors($user_id, $plain);
    }

    /**
     * @param Author|int $author
     * @param int $user_id
     * @return Author
     */
    public function validate($author, int $user_id): Author
    {
        if (! $author instanceof Author) {
            $author = $this->findOrFail((int)$author);
        }
        if ($author->getUser()->getId() != $user_id) {
            throw new NotFoundHttpException("Action not allowed");
        }
        return $author;
    }

    /**
     * @return AuthorRepository
     */
    protected function repository(): AuthorRepository
    {
        return $this->author;
    }
}
