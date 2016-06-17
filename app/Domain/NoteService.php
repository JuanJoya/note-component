<?php

namespace Note\Domain;
use Note\Infrastructure\NoteRepository;

class NoteService extends Service
{
    /**
     * @param NoteRepository $notes
     */
    public function __construct(NoteRepository $notes)
    {
        parent::__construct($notes);
    }

    public function save(array $params)
    {
        $this->entity->save($params);
    }

    public function update(array $params)
    {
        $this->entity->update($params);
    }

    /**
     * @param $authorId
     * @return \Illuminate\Support\Collection
     */
    public function notes($authorId)
    {
        return $this->entity->notes($authorId);
    }
}
