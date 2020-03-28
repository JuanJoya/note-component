<?php

declare(strict_types=1);

namespace Note\Infrastructure;

use Note\Domain\Author;
use Illuminate\Support\Collection;
use Note\Domain\User;

class AuthorRepository extends BaseRepository
{
    /**
     * @param string $query
     * @return Collection
     */
    public function all(string $query = null): Collection
    {
        return parent::all(
            "SELECT a.*, u.email FROM authors a
             INNER JOIN users u ON u.id = a.user_id
             ORDER BY a.id ASC"
        );
    }

    /**
     * @param int|string $param
     * @param string $type
     * @param string $query
     * @return object|null
     */
    public function find($param, string $type = 'id', string $query = null)
    {
        return parent::find(
            $param,
            $type,
            "SELECT a.*, u.email FROM authors a
             INNER JOIN users u ON u.id = a.user_id
             WHERE a.{$type} = :{$type}"
        );
    }

    /**
     * @param array $attributes
     * @return void
     */
    public function save(array $attributes): void
    {
        $this->bindParams = [
            ':user_id' => $attributes['user_id'],
            ':username' => $attributes['username'],
            ':slug' => $attributes['slug']
        ];
        $this->executeSingleQuery(
            "INSERT INTO authors (user_id, username, slug) VALUES (:user_id, :username, :slug)"
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
     * @param int $userId
     * @return Collection
     */
    public function authors(int $user_id): Collection
    {
        $this->bindParams = [':user_id' => $user_id];
        $result = $this->getResultsFromQuery(
            "SELECT a.*, u.email FROM authors a
             INNER JOIN users u ON u.id = a.user_id
             WHERE a.user_id = :user_id"
        );
        return $this->mapToEntity($result);
    }

    /**
     * @param array $result ResultSet de la base de datos.
     * @return Author
     */
    protected function mapEntity(array $result): Author
    {
        $user = new User(
            $result['email'],
            $result['user_id']
        );
        return new Author(
            $user,
            $result['username'],
            $result['slug'],
            $result['id']
        );
    }

    /**
     * @return string nombre de la tabla en la base de datos.
     */
    protected function table(): string
    {
        return 'authors';
    }
}
