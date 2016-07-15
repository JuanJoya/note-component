<?php

namespace Note\Infrastructure;
use Note\Domain\User;

class UserRepository extends BaseRepository
{
    /**
     * @return string
     */
    protected function table()
    {
        return 'users';
    }

    /**
     * @param string $userId
     * @return User
     */
    public function findUser($userId)
    {
        $this->query = "SELECT * FROM users WHERE id = :userId";
        $this->bindParams = [':userId' => $userId];
        $this->getResultsFromQuery();

        return $this->mapEntity(array_shift($this->rows));
    }

    /**
     * @param array $result
     * @return User
     */
    protected function mapEntity(array $result)
    {
        $user = new User(
            $result['email'],
            $result['password'],
            $result['id']
        );

        $user->setName($result['first_name'],$result['last_name']);

        return $user;
    }
}