<?php

namespace App\Infrastructure\Persistence;

use App\Application\DataSource\UserDataSource;
use App\Domain\User;

class FileUserDataSource implements UserDataSource
{
    public function findUserById(string $user_id): ?User
    {
        return new User($user_id);
    }

    public function getAll(): array
    {
    }
}
