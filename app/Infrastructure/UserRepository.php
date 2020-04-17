<?php

declare(strict_types=1);

namespace Note\Infrastructure;

use Note\Domain\User;

class UserRepository extends BaseRepository
{
    /**
     * @param array $attributes
     * @return void
     */
    public function save(array $attributes): void
    {
        $this->bindParams = [
            ':email'    => $attributes['email'],
            ':password' => password_hash($attributes['password'], PASSWORD_DEFAULT)
        ];
        $this->executeSingleQuery(
            "INSERT INTO users (email, password)
             VALUES (:email, :password)"
        );
    }
    
    /**
     * @param array $attributes
     * @return void
     */
    public function update(array $attributes): void
    {
        //TODO
    }
    
    /**
     * @param array $result ResultSet de la base de datos.
     * @return User
     */
    protected function mapEntity(array $result): User
    {
        return new User(
            $result['email'],
            $result['id'],
            $result['password']
        );
    }

    /**
     * @return string nombre de la tabla en la base de datos.
     */
    protected function table(): string
    {
        return 'users';
    }
}
