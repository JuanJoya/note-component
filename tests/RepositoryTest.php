<?php

use Illuminate\Support\Collection;
use Note\Domain\Note;
use Note\Infrastructure\AuthorRepository;
use Note\Infrastructure\NoteRepository;
use Note\Infrastructure\UserRepository;

class RepositoryTest extends PHPUnit_Framework_TestCase
{
    function __construct()
    {
        $this->NoteRepo = new NoteRepository(new AuthorRepository(new UserRepository()));
    }

    function test_all_notes()
    {
        $result = $this->NoteRepo->all();

        $this->assertInstanceOf(Collection::class, $result);

        foreach ($result as $note) {
            $this->assertInstanceOf(Note::class, $note);
        }
    }

    function test_find_a_note_by_id()
    {
        $post = $this->NoteRepo->find(1);

        $this->assertInstanceOf(Note::class, $post);
    }

    function test_searching_posts()
    {
        $results = $this->NoteRepo->search('#4');

        $this->assertInstanceOf(Collection::class, $results);
    }
}
