<?php

namespace Note\Infrastructure;
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
     * @return string
     */
    protected function table()
    {
        return 'notes';
    }

    /**
     * @param array $params campos necesarios para crear Note en DB
     */
    public function save(array $params)
    {
        $this->query = "INSERT INTO notes
                          (title, content, author_id)
                        VALUES
                          (:title, :content, :author_id)";
        $this->bindParams = [
            ':title' => $params['title'],
            ':content' => $params['content'],
            ':author_id' => $params['author_id'],
        ];
        $this->executeSingleQuery();
    }

    /**
     * @param array $params campos necesarios para modificar Note en DB
     */
    public function update(array $params)
    {
        $this->query = "UPDATE notes
                        SET  title = :title,
                             content = :content
                        WHERE id = :id";

        $this->bindParams = [
            ':title' => $params['title'],
            ':content' => $params['content'],
            ':id' => $params['id'],
        ];
        $this->executeSingleQuery();
    }

    /**
     * @param string $query parámetro de búsqueda en title o content
     * @return \Illuminate\Support\Collection
     */
    public function search($query)
    {
        $this->query = 'SELECT * FROM notes WHERE content LIKE :query OR title LIKE :query';
        $query = "%$query%";
        $this->bindParams = [':query' => $query];
        $this->getResultsFromQuery();

        return $this->mapToEntity($this->rows);
    }

    /**
     * @param string $authorId
     * @return \Illuminate\Support\Collection de Note
     */
    public function notes($authorId)
    {
        $this->query = "SELECT * FROM notes WHERE author_id = :Id";
        $this->bindParams = [':Id' => $authorId];
        $this->getResultsFromQuery();

        return $this->mapToEntity($this->rows);
    }

    /**
     * @param array $result
     * @return Note
     */
    protected function mapEntity(array $result)
    {
        $author = $this->authorRepository->findAuthor($result['author_id']);

        return new Note(
            $author,
            $result['title'],
            $result['content'],
            $result['id']
        );
    }

}
