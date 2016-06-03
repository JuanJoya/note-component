<?php

namespace Note\Domain;

class Note
{
    /**
     * @var Author
     */
    private $author;
    private $title;
    private $content;

    public function __construct($author, $title, $content)
    {
        $this->setAuthor($author);
        $this->title = $title;
        $this->content = $content;
    }

    public function setAuthor($author)
    {
        if(!$author instanceof Author)
        {
            throw new \InvalidArgumentException("This isn't a author");
        }
        $this->author = $author;
    }
    public function getTitle()
    {
        return $this->title;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getAuthor()
    {
        return $this->author->getUsername();
    }

    public function getAuthorName()
    {
        return $this->author->getFullName();
    }
}