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
        parent::__construct($note);
    }

    /**
     * @param array $params contiene Author id, title & content
     */
    public function save(array $params)
    {
        $this->entity->save($params);
    }

    /**
     * @param array $params contiene Note id, title & content
     */
    public function update(array $params)
    {
        $this->entity->update($params);
    }

    /**
     * @param string $query patron a buscar en la DB del title o content
     * @return \Illuminate\Support\Collection de Note
     */
    public function search($query)
    {
        return $this->entity->search($query);
    }

    /**
     * @param string $authorId
     * @return \Illuminate\Support\Collection de Note
     */
    public function notes($authorId)
    {
        return $this->entity->notes($authorId);
    }
}
