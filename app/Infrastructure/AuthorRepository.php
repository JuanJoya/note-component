<?php

namespace Note\Infrastructure;
use Note\Domain\Author;

class AuthorRepository extends BaseRepository
{
    /**
     * @var UserRepository instancia del repositorio de User
     */
    private $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return string
     */
    protected function table()
    {
        return 'authors';
    }

    /**
     * @param string $authorId
     * @return Author instancia de Entity Author
     */
    public function findAuthor($authorId)
    {
        $this->query = "SELECT * FROM authors WHERE id = :authorId";
        $this->bindParams = [':authorId' => $authorId];
        $this->getResultsFromQuery();

        return $this->mapEntity(array_shift($this->rows));
    }

    /**
     * @param string $userId
     * @return \Illuminate\Support\Collection de Author
     */
    public function authors($userId)
    {
        $this->query = "SELECT * FROM authors WHERE user_id = :userId";
        $this->bindParams = [':userId' => $userId];
        $this->getResultsFromQuery();

        return $this->mapToEntity($this->rows);
    }

    /**
     * @param array $result
     * @return Author
     */
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