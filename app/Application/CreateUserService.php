<?php

namespace App\Application;

use App\Application\DataSource\WalletDataSource;
use App\Application\Exceptions\UserNotFoundException;
use App\Application\DataSource\CoinDataSource;
use App\Application\DataSource\UserDataSource;
use App\Domain\Wallet;
use App\Domain\User;

class CreateUserService
{
    private UserDataSource $UserRepository;


    public function __construct(UserDataSource $UserRepository)
    {
        $this->UserRepository = $UserRepository;
    }

    /**
     * @throws UserNotFoundException
     */
    public function executeUser(string $user_id): ?User
    {
        $user = $this->UserRepository->findUserById($user_id);
        return $user;
    }
}
