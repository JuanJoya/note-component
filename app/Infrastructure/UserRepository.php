<?php

namespace Note\Infrastructure;
use Note\Domain\User;

class UserRepository extends BaseRepository
{
    protected function table()
    {
        return 'users';
    }

    public function findUser($userId)
    {
        $this->query = "SELECT * FROM users WHERE id = :userId";
        $this->bindParams = [':userId' => $userId];
        $this->getResultsFromQuery();

        return $this->mapEntity(array_shift($this->rows));
    }

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