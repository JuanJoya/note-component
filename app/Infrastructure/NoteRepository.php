<?php

namespace Note\Infrastructure;

use Helper;
use Note\Domain\Note;

class NoteRepository extends BaseRepository
{
    /**
     * @var AuthorRepository instancia del repositorio de Note
     */
    private $authorRepository;

    /**
     * @param AuthorRepository $authorRepository
     */
    public function __construct(AuthorRepository $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    /**
     * @param Note $note
     */
    public function save(Note $note)
    {
        $this->validateAuthor($note->getAuthor()->getAuthorId());
        $this->query = "INSERT INTO notes
                          (title, content, author_id)
                        VALUES
                          (:title, :content, :author_id)";

        $this->bindParams = [
            ':title'     => $note->getTitle(),
            ':content'   => $note->getContent(),
            ':author_id' => $note->getAuthor()->getAuthorId(),
        ];
        $this->executeSingleQuery();
    }

    /**
     * @param Note $note
     */
    public function update(Note $note)
    {
        $this->validateNote($note->getId());
        $this->query = "UPDATE notes
                        SET  title = :title,
                             content = :content
                        WHERE id = :id";

        $this->bindParams = [
            ':title'   => $note->getTitle(),
            ':content' => $note->getContent(),
            ':id'      => $note->getId(),
        ];
        $this->executeSingleQuery();
    }

    /**
     * @param string $query parámetro de búsqueda en title o content
     * @return \Illuminate\Support\Collection
     */
    public function search($query)
    {
        $this->query = "SELECT * FROM notes WHERE content LIKE :query OR title LIKE :query";
        $query = '%'.Helper::escapeLike($query).'%';
        $this->bindParams = [':query' => $query];
        $this->getResultsFromQuery();

        return $this->mapToEntity($this->rows);
    }

    /**
     * @param string $authorId
     * @return \Illuminate\Support\Collection de Note
     */
    public function notesByAuthor($authorId)
    {
        $this->query = "SELECT * FROM notes WHERE author_id = :id";
        $this->bindParams = [':id' => $authorId];
        $this->getResultsFromQuery();

        return $this->mapToEntity($this->rows);
    }

    /**
     * @return string nombre de la tabla en db
     */
    protected function table()
    {
        return 'notes';
    }

    /**
     * @param array $result datos de la db
     * @return Note
     */
    protected function mapEntity(array $result)
    {
        $author = $this->authorRepository->find($result['author_id']);
        
        return new Note(
            $author,
            $result['title'],
            $result['content'],
            $result['id']
        );
    }

    /**
     * @param string $authorId
     */
    private function validateAuthor($authorId)
    {
        if (!$this->authorRepository->inDatabase($authorId)) {
            throw new \LogicException("The author of this note is not stored in database");
        }
    }

    /**
     * @param string $noteId
     */
    private function validateNote($noteId)
    {
        if (!$this->inDatabase($noteId)) {
            throw new \LogicException("This note is not stored in database");
        }
    }

}
