<?php

namespace Note\Domain;
use Note\Infrastructure\UserRepository;

class UserService extends Service
{
    /**
     * @param UserRepository $user instancia del repositorio de User
     */
    public function __construct(UserRepository $user)
    {
        parent::__construct($user);
    }
}
