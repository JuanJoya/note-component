<?php

declare(strict_types=1);

namespace Note\Infrastructure;

use Note\Domain\Author;
use Illuminate\Support\Collection;
use Note\Domain\User;

class AuthorRepository extends BaseRepository
{
    /**
     * @param array $attributes
     * @return void
     */
    public function save(array $attributes): void
    {
        $this->bindParams([
            ':user_id'  => $attributes['user_id'],
            ':username' => $attributes['username'],
            ':slug'     => $attributes['slug']
        ]);
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
        $this->bindParams([':user_id' => $user_id]);
        $result = $this->getResultsFromQuery(
            $this->selectQuery() . "WHERE a.user_id = :user_id"
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

    /**
     * @return string
     */
    protected function allQuery(): string
    {
        return $this->selectQuery() . "ORDER BY a.id DESC";
    }

    /**
     * @param string $type
     * @return string
     */
    public function findQuery(string $type): string
    {
        return $this->selectQuery() . "WHERE a.{$type} = :{$type} ORDER BY a.id DESC";
    }

    /**
     * @return string
     */
    private function selectQuery(): string
    {
        return "SELECT a.*, u.email FROM authors a
                INNER JOIN users u ON u.id = a.user_id ";
    }
}
