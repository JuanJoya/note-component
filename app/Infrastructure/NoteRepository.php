<?php

namespace Note\Infrastructure;
use Note\Domain\Note;

class NoteRepository extends BaseRepository
{
    private $authorRepository;

    public function __construct(AuthorRepository $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    protected function table()
    {
        return 'notes';
    }

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

    protected function mapEntity(array $result)
    {
        $author = $this->authorRepository->findAuthor($result['author_id']);

        return new Note(
            $author,
            $result['title'],
            $result['content']
        );
    }

}
