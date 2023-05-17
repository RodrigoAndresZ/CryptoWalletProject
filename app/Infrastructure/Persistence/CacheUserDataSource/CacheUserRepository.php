<?php

namespace App\Infrastructure\Persistence\CacheUserDataSource;

use App\Application\UserDataSource\UserDataSource;
use App\Application\UserDataSource\UserRepository;
use App\Domain\User;
use Illuminate\Support\Facades\Cache;

class CacheUserRepository implements UserDataSource
{
    public function findUserbyId(string $user_id): ?User
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
