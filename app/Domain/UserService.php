<?php

namespace Note\Domain;
use Note\Infrastructure\UserRepository;

class UserService extends Service
{
    /**
     * @param UserRepository $users
     */
    public function __construct(UserRepository $users)
    {
        parent::__construct($users);
    }
}
