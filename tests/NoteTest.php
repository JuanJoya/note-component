<?php

use Note\Domain\Author;
use Note\Domain\Note;

class NoteTest extends PHPUnit_Framework_TestCase
{
    function test_create_note()
    {
        $author = new Author('juan@pc.co','12345','@ingjuanjoya');

        $note = new Note($author,'Note 1', 'This is a Note test');

        $this->assertInstanceOf(Note::class, $note);
    }

    function test_create_note_fail()
    {
        $this->setExpectedException(\InvalidArgumentException::class);
        $note = new Note('@juanjoya','Note 1', 'This is a Note test');
    }

    function test_get_data()
    {
        $author = new Author('juan@pc.co','12345','@ingjuanjoya');

        $note = new Note($author,'Note 1', 'This is a Note test');

        $title = $note->getTitle();
        $content = $note->getContent();
        $username = $note->getAuthor();

        $this->assertEquals('Note 1', $title);
        $this->assertEquals('This is a Note test', $content);
        $this->assertEquals('@ingjuanjoya', $username);
    }
}
