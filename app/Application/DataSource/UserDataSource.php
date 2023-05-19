<?php

namespace App\Application\DataSource;

use App\Domain\User;

interface UserDataSource
{
    public function findByEmail(string $email): User;

    /**
     * @return User[]
     */
    public function getAll(): array;
}
