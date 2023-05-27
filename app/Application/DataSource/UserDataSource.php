<?php

namespace App\Application\DataSource;

use App\Domain\User;

interface UserDataSource
{
    public function findUserbyId(string $user_id): ?User;


    /**
     * @return User[]
     */
    public function getAll(): array;
}
