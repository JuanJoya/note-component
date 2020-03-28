<?php

declare(strict_types=1);

namespace Note\Domain;

class Note
{
    /**
     * @var Author
     */
    private $author;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $created_at;

    /**
     * @var string
     */
    private $updated_at;

    /**
     * @var int
     */
    private $id;

    /**
     * @param Author $author
     * @param string $title
     * @param string $content
     * @param string $created_at
     * @param string $updated_at
     * @param int $id
     */
    public function __construct(
        Author $author,
        string $title,
        string $content,
        string $created_at,
        string $updated_at,
        int $id
    ) {
        $this->author = $author;
        $this->title = $title;
        $this->content = $content;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->id = $id;
    }

    /**
     * @param string $title
     * @return void
     */
    public function setTitle(string $title): void
    {
        if (empty($title)) {
            throw new \InvalidArgumentException("Empty Title");
        }
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $content
     * @return void
     */
    public function setContent(string $content): void
    {
        if (empty($content)) {
            throw new \InvalidArgumentException("Empty Content");
        }
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return Author
     */
    public function getAuthor(): Author
    {
        return $this->author;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    /**
     * @param string $timestamp
     * @return void
     */
    public function setUpdatedAt(string $timestamp): void
    {
        $this->updated_at = $timestamp;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
