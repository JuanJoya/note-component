<?php

namespace Note\Domain;
use Note\Infrastructure\UserRepository;

class UserService
{
    /**
     * @var UserRepository
     */
    private $users;

    /**
     * @param UserRepository $users
     */
    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    /**
     * @param $id
     * @return User
     */
    public function find($id)
    {
        return $this->users->findUser($id);
    }
}
