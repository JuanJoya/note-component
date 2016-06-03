<?php

namespace Note\Domain;

class User
{
    protected $firstName;
    protected $lastName;
    protected $email;
    protected $pass;
    protected $id;

    public function __construct($email, $pass, $id = null)
    {
        $this->setEmail($email);
        $this->setPassword($pass);
        $this->id = $id;
    }

    public function setEmail($email)
    {
        if (! filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            throw new \InvalidArgumentException(
                "Invalid email address: [$email]"
            );
        }
        $this->email = $email;
    }

    public function setPassword($pass)
    {
        if(empty($pass))
        {
            throw new \InvalidArgumentException(
                "Empty password"
            );
        }
        $this->pass = $pass;
    }

    public function setName($firstName, $lastName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->pass;
    }

    public function getFullName()
    {
        return $this->getFirstName().' '.$this->getLastName();
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }
}