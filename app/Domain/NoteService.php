<?php

namespace Note\Domain;

use Note\Infrastructure\NoteRepository;

class NoteService extends Service
{
    /**
     * @param NoteRepository $note instancia del repositorio de Note
     */
    public function __construct(NoteRepository $note)
    {
        $this->entity = $note;
    }

    /**
     * @param Note $note
     */
    public function save(Note $note)
    {
        $this->entity->save($note);
    }

    /**
     * @param Note $note
     */
    public function update(Note $note)
    {
        $this->entity->update($note);
    }

    /**
     * @param Author $author
     * @return \Illuminate\Support\Collection de Note
     */
    public function notesByAuthor(Author $author)
    {
        if(empty($author->getAuthorId())) {
            throw new \InvalidArgumentException("Empty Author id");
        }

        return $this->entity->notesByAuthor($author->getAuthorId());
    }

    /**
     * @param string $query patron a buscar en la DB del title o content
     * @return null|\Illuminate\Support\Collection
     */
    public function search($query)
    {
        $query = trim($query);
        if(!empty($query)) {
            return $this->entity->search($query);
        }
    }
}
