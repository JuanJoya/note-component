<?php

use Note\Domain\Author;
use Note\Domain\Note;

class NoteTest extends PHPUnit_Framework_TestCase
{
    function test_create_note()
    {
        $author = new Author('juan@pc.co', '12345', '@ingjuanjoya');
        $note   = new Note($author, 'Note 1', 'This is a Note test');

        $this->assertInstanceOf(Note::class, $note);
    }

    function test_create_note_fail()
    {
        $this->setExpectedException(\InvalidArgumentException::class);

        $author = new Author('juan@pc.co', '12345', '@ingjuanjoya');
        $note   = new Note($author, '', '');
    }

    function test_get_data()
    {
        $author = new Author('juan@pc.co', '12345', '@ingjuanjoya');
        $note   = new Note($author, 'Note 1', 'This is a Note test');

        $this->assertEquals('Note 1', $note->getTitle());
        $this->assertEquals('This is a Note test', $note->getContent());
        $this->assertEquals('@ingjuanjoya', $note->getAuthor()->getUsername());
    }
}
