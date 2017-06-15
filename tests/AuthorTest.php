<?php

use Note\Domain\Author;

class AuthorTest extends PHPUnit_Framework_TestCase
{
    function test_create_author()
    {
        $author = new Author('juan@pc.co', '12345', '@ingjuanjoya');
        $this->assertInstanceOf(Author::class, $author);
    }

    function test_create_author_fail()
    {
        $this->setExpectedException(\InvalidArgumentException::class);
        $author = new Author('juan@pc.co', '12345', '');
    }

    function test_get_data()
    {
        $author = new Author('juan@pc.co', '12345', '@ingjuanjoya');
        $author->setName('juan', 'joya');

        $this->assertEquals('juan joya', $author->getFullName());
        $this->assertEquals('@ingjuanjoya', $author->getUsername());
    }
}
