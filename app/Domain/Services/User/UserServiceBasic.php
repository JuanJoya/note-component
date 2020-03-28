<?php

declare(strict_types=1);

namespace Note\Domain\Services\User;

use Note\Domain\User;
use Note\Domain\Services\BaseService;
use Note\Infrastructure\UserRepository;

class UserServiceBasic extends BaseService implements UserService
{
    /**
     * @var UserRepository
     */
    private $user;

    /**
     * @param UserRepository $user
     */
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    /**
     * @param array $attributes
     * @return User
     */
    public function create(array $attributes): User
    {
        $this->repository()->save($attributes);
        return $this->find($attributes['email'], 'email');
    }

    /**
     * @return UserRepository
     */
    protected function repository(): UserRepository
    {
        return $this->user;
    }
}
