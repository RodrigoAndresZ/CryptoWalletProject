<?php

namespace App\Application\UserDataSource;

use App\Domain\User;

interface UserRepository
{
    public function findByEmail(string $email): ?User;

    public function findUserbyId(string $user_id): ?User;


    /**
     * @return User[]
     */
    public function getAll(): array;
}
