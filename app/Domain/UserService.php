<?php

namespace Note\Domain;
use Note\Infrastructure\UserRepository;

class UserService extends Service
{
    /**
     * @param UserRepository $users instancia del repositorio de User
     */
    public function __construct(UserRepository $users)
    {
        parent::__construct($users);
    }
}
