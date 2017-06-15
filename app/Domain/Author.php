<?php

namespace Note\Domain;

class Author extends User
{
    /**
     * @var string seudónimo de un Author
     */
    protected $username;
    /**
     * @var null|string id de un Author
     */
    protected $authorId;

    /**
     * @param string $email correo del User
     * @param string $password contraseña del User
     * @param string $username
     * @param null|string $authorId
     * @param null|string $userId
     */
    public function __construct($email, $password, $username, $authorId = null, $userId = null)
    {
        parent::__construct($email, $password, $userId);
        $this->setUsername($username);
        $this->authorId = $authorId;
    }

    /**
     * @param User $user
     * @param string $username
     * @param null|string $authorId
     * @return Author
     */
    public static function create(User $user, $username, $authorId = null)
    {
        return new Author(
            $user->getEmail(),
            $user->getPassword(),
            $username,
            $authorId,
            $user->getId()
        );
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        if(empty($username)) {
            throw new \InvalidArgumentException("Empty UserName");
        }
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return null|string
     */
    public function getAuthorId()
    {
        return $this->authorId;
    }
}
