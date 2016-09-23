<?php

namespace Note\Domain;

class User
{
    /**
     * @var string
     */
    protected $firstName;
    /**
     * @var string
     */
    protected $lastName;
    /**
     * @var string
     */
    protected $email;
    /**
     * @var string
     */
    protected $pass;
    /**
     * @var null|string
     */
    protected $id;

    /**
     * @param string $email
     * @param string $pass
     * @param null|string $id
     */
    public function __construct($email, $pass, $id = null)
    {
        $this->setEmail($email);
        $this->setPassword($pass);
        $this->id = $id;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException(
                "Invalid email address: [$email]"
            );
        }
        $this->email = $email;
    }

    /**
     * @param string $pass
     */
    public function setPassword($pass)
    {
        if(empty($pass)) {
            throw new \InvalidArgumentException(
                "Empty password"
            );
        }
        $this->pass = $pass;
    }

    /**
     * @param string $firstName
     * @param string $lastName
     */
    public function setName($firstName, $lastName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->pass;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->getFirstName().' '.$this->getLastName();
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return null|string
     */
    public function getId()
    {
        return $this->id;
    }
}
