<?php

namespace Note\Domain;
use Note\Infrastructure\NoteRepository;

class NoteService
{
    /**
     * @var NoteRepository
     */
    private $notes;

    /**
     * @param NoteRepository $notes
     */
    public function __construct(NoteRepository $notes)
    {
        $this->notes = $notes;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function listNotes()
    {
        return $this->notes->all();
    }

    public function saveNote(array $params)
    {
        $this->notes->save($params);
    }
}
