<?php

namespace App\Application\UserDataSource;

use App\Domain\User;

interface UserRepository
{
    public function findUserbyId(string $user_id): ?User;
}
