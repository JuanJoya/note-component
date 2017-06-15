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
     * @param Author $author
     */
    public function save(Author $author)
    {
        $this->validateUser($author->getId());
        $this->query = "INSERT INTO authors (user_id, username) VALUES (:user_id, :username)";
        $this->bindParams = [
            ':user_id'  => $author->getId(),
            ':username' => $author->getUsername()
        ];
        $this->executeSingleQuery();
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
     * @return string nombre de la tabla en db
     */
    protected function table()
    {
        return 'authors';
    }

    /**
     * @param array $result datos de la db
     * @return Author
     */
    protected function mapEntity(array $result)
    {
        $user   = $this->userRepository->find($result['user_id']);
        $author = new Author(
            $user->getEmail(),
            $user->getPassword(),
            $result['username'],
            $result['id'],
            $result['user_id']
        );

        $author->setName($user->getFirstName(), $user->getLastName());

        return $author;
    }

    /**
     * @param string $userId
     */
    private function validateUser($userId)
    {
        if (!$this->userRepository->inDatabase($userId)) {
            throw new \LogicException(
                "This author does not have an associated user in database"
            );
        }
    }
}
