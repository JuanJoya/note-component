<?php
namespace Note\Domain;

class Author extends User
{
    protected $username;
    protected $authorId;

    public function __construct($email, $password, $username, $authorId = null)
    {
        parent::__construct($email, $password);
        $this->setUsername($username);
        $this->authorId = $authorId;
    }

    public function setUsername($username)
    {
        if(empty($username))
        {
            throw new \InvalidArgumentException("Empty UserName");
        }
        $this->username = $username;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getAuthorId()
    {
        return $this->authorId;
    }
}