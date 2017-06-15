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
    public function __construct(Author $author, $title, $content, $id = null)
    {
        $this->author = $author;
        $this->setTitle($title);
        $this->setContent($content);
        $this->id = $id;
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
    public function setTitle($title)
    {
        if(empty($title)) {
            throw new \InvalidArgumentException("Empty Title");
        }
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
        if(empty($content)) {
            throw new \InvalidArgumentException("Empty Content");
        }
        $this->content = $content;
    }

    /**
     * @return Author
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @return null|string
     */
    public function getId()
    {
        return $this->id;
    }
}
