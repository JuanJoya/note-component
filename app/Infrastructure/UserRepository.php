<?php

namespace Note\Infrastructure;

use Note\Domain\User;

class UserRepository extends BaseRepository
{
    /**
     * @param User $user
     */
    public function save(User $user)
    {
        $this->query = "INSERT INTO users
                          (email, password, first_name, last_name)
                        VALUES
                          (:email, :password, :first_name, :last_name)";
        $this->bindParams = [
            ':email'      => $user->getEmail(),
            ':password'   => password_hash($user->getPassword(), PASSWORD_DEFAULT),
            ':first_name' => $user->getFirstName(),
            ':last_name'  => $user->getLastName()
        ];
        $this->executeSingleQuery();
    }

    /**
     * @param array $result datos de la db
     * @return User
     */
    protected function mapEntity(array $result)
    {
        $user = new User(
            $result['email'],
            $result['password'],
            $result['id']
        );
        $user->setName($result['first_name'], $result['last_name']);

        return $user;
    }

    /**
     * @return string nombre de la tabla en db
     */
    protected function table()
    {
        return 'users';
    }
}
