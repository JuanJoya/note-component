<?php

namespace Note\Infrastructure;
use Note\Domain\Author;

class AuthorRepository extends BaseRepository
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    protected function table()
    {
        return 'authors';
    }

    public function findAuthor($authorId)
    {
        $this->query = "SELECT * FROM authors WHERE id = :authorId";
        $this->bindParams = [':authorId' => $authorId];
        $this->getResultsFromQuery();

        return $this->mapEntity(array_shift($this->rows));
    }

    public function authors($userId)
    {
        $this->query = "SELECT * FROM authors WHERE user_id = :userId";
        $this->bindParams = [':userId' => $userId];
        $this->getResultsFromQuery();

        return $this->mapToEntity($this->rows);
    }

    protected function mapEntity(array $result)
    {
        $user = $this->userRepository->findUser($result['user_id']);

        $author = new Author(
            $user->getEmail(),
            $user->getPassword(),
            $result['username'],
            $result['id']
        );

        $author->setName($user->getFirstName(),$user->getLastName());

        return $author;
    }
}