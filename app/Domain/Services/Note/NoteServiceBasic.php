<?php

declare(strict_types=1);

namespace Note\Domain\Services\Note;

use Note\Domain\Note;
use Note\Domain\Services\BaseService;
use Illuminate\Support\Collection;
use Note\Infrastructure\NoteRepository;

class NoteServiceBasic extends BaseService implements NoteService
{
    /**
     * @var NoteRepository
     */
    private $note;

    /**
     * @param NoteRepository $note
     */
    public function __construct(NoteRepository $note)
    {
        $this->note = $note;
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->repository()->all()->sortByDesc(function (Note $note) {
            return $note->getCreatedAt();
        });
    }

    /**
     * @param string $pattern
     * @return Collection
     */
    public function search(string $pattern): Collection
    {
        return $this->repository()->search(trim($pattern));
    }

    /**
     * @param int $author_id
     * @return Collection
     */
    public function authorNotes(int $author_id): Collection
    {
        return $this->repository()->notes($author_id);
    }

    /**
     * @return NoteRepository
     */
    protected function repository(): NoteRepository
    {
        return $this->note;
    }
}
