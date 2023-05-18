<?php

namespace App\Infrastructure\Persistence\CacheUserDataSource;

use App\Application\UserDataSource\UserRepository;
use App\Domain\User;

class CacheUserRepository implements UserRepository
{
    public function findUserById(string $user_id): ?User
    {
        //return Cache::get($user_id);
        return new User(1, "email@email.com");
    }

    public function findByEmail(string $email): User
    {
        return new User(2, "email@email.com");
    }

    public function getAll(): array
    {
        // TODO: Implement getAll() method.
    }
}
