<?php

declare(strict_types=1);

namespace Note\Infrastructure;

use Note\Domain\{User, Author, Note};
use Illuminate\Support\Collection;

class NoteRepository extends BaseRepository
{
    /**
     * @param string $query
     * @return Collection
     */
    public function all(string $query = null): Collection
    {
        return parent::all(
            "SELECT n.*, a.username, a.slug, a.user_id, u.email
             FROM notes n
             INNER JOIN authors a ON a.id = n.author_id
             INNER JOIN users u ON u.id = a.user_id
             ORDER BY n.id ASC"
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
            "SELECT n.*, a.username, a.slug, a.user_id, u.email
             FROM notes n
             INNER JOIN authors a ON a.id = n.author_id
             INNER JOIN users u ON u.id = a.user_id
             WHERE n.{$type} = :{$type}"
        );
    }

    /**
     * @param array $attributes
     * @return void
     */
    public function save(array $attributes): void
    {
        $this->bindParams = [
            ':title'     => $attributes['title'],
            ':content'   => $attributes['content'],
            ':author_id' => $attributes['author_id'],
        ];
        $this->executeSingleQuery(
            "INSERT INTO notes (title, content, author_id)
             VALUES (:title, :content, :author_id)"
        );
    }

    /**
     * @param array $attributes
     * @return void
     */
    public function update(array $attributes): void
    {
        $this->validateNote($attributes['id']);
        $this->bindParams = [
            ':title'      => $attributes['title'],
            ':content'    => $attributes['content'],
            ':updated_at' => $attributes['updated_at'],
            ':id'         => $attributes['id'],
        ];
        $this->executeSingleQuery(
            "UPDATE notes
             SET title = :title, content = :content, updated_at = :updated_at 
             WHERE id = :id"
        );
    }

    /**
     * @param string $query
     * @return Collection
     * Desactivar [ATTR_EMULATE_PREPARES] implica que no se pueden repetir
     * los placeholders (:query) en la sentencia SQL.
     */
    public function search(string $query): Collection
    {
        $query = '%' . escapeLike($query) . '%';
        $this->bindParams = [
            ':content' => $query,
            ':title'   => $query
        ];
        $result = $this->getResultsFromQuery(
            "SELECT n.*, a.username, a.slug, a.user_id, u.email
             FROM notes n
             INNER JOIN authors a ON a.id = n.author_id
             INNER JOIN users u ON u.id = a.user_id
             WHERE n.content LIKE :content OR n.title LIKE :title"
        );
        return $this->mapToEntity($result);
    }

    /**
     * @param int $author_id
     * @return Collection
     */
    public function notes(int $author_id): Collection
    {
        $this->bindParams = [':author_id' => $author_id];
        $result = $this->getResultsFromQuery(
            "SELECT n.*, a.username, a.slug, a.user_id, u.email
             FROM notes n
             INNER JOIN authors a ON a.id = n.author_id
             INNER JOIN users u ON u.id = a.user_id
             WHERE n.author_id = :author_id
             ORDER BY n.updated_at DESC"
        );
        return $this->mapToEntity($result);
    }

    /**
     * @param array $result ResultSet de la base de datos.
     * @return Note
     */
    protected function mapEntity(array $result): Note
    {
        $user = new User(
            $result['email'],
            $result['user_id']
        );
        $author = new Author(
            $user,
            $result['username'],
            $result['slug'],
            $result['author_id'],
        );
        return new Note(
            $author,
            $result['title'],
            $result['content'],
            $result['created_at'],
            $result['updated_at'],
            $result['id']
        );
    }

    /**
     * @return string nombre de la tabla en la base de datos.
     */
    protected function table(): string
    {
        return 'notes';
    }

    /**
     * @param int $note_id
     */
    private function validateNote(int $note_id)
    {
        if (!$this->inDatabase($note_id)) {
            throw new \RuntimeException("This note is not stored in database");
        }
    }
}
