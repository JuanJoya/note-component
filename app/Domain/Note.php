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
    private $id;

    public function __construct($author, $title, $content, $id = null)
    {
        $this->setAuthor($author);
        $this->title = $title;
        $this->content = $content;
        $this->id = $id;
    }

    public function setAuthor($author)
    {
        if(!$author instanceof Author)
        {
            throw new \InvalidArgumentException("This isn't an author");
        }
        $this->author = $author;
    }

    public function getId()
    {
        return $this->id;
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