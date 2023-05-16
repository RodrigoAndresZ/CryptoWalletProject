<?php

namespace App\Infrastructure\Persistence\CacheUserDataSource;

use App\Application\UserDataSource\UserRepository;
use App\Domain\User;

class CacheUserRepository implements UserRepository
{
    public function findUserbyId(string $user_id): ?User
    {
        return new User(1, "email@email.com");
    }
}
