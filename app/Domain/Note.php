<?php

namespace Note\Domain;

class Note
{
    /**
     * @var Author instancia de la clase Author
     */
    private $author;
    /**
     * @var string titulo de una nota
     */
    private $title;
    /**
     * @var string contenido de una nota
     */
    private $content;
    /**
     * @var null|string id de una nota
     */
    private $id;

    /**
     * @param Author $author
     * @param string $title
     * @param string $content
     * @param null|string $id
     */
    public function __construct($author, $title, $content, $id = null)
    {
        $this->setAuthor($author);
        $this->title = $title;
        $this->content = $content;
        $this->id = $id;
    }

    /**
     * @param Author $author
     */
    public function setAuthor($author)
    {
        if(!$author instanceof Author)
        {
            throw new \InvalidArgumentException("This isn't an author");
        }
        $this->author = $author;
    }

    /**
     * @return null|string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitile($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return $this->author->getUsername();
    }

    /**
     * @return string
     */
    public function getAuthorName()
    {
        return $this->author->getFullName();
    }
}