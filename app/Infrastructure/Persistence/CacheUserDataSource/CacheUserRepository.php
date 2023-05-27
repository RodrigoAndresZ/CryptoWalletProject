<?php

namespace App\Infrastructure\Persistence\CacheUserDataSource;

use App\Application\DataSource\UserDataSource;
use App\Domain\User;
use Illuminate\Support\Facades\Cache;

class CacheUserRepository implements UserDataSource
{
    public function findUserById(string $user_id): ?User
    {
        return new User('1');
    }



    public function getAll(): array
    {
        // TODO: Implement getAll() method.
    }
}
