<?php

namespace App\Application;

use App\Application\UserDataSource\UserRepository;
use App\Application\WalletDataSource\WalletRepository;

class CreateWalletService
{
    private UserRepository $userDataSource;
    private WalletRepository $walletDataSource;

    public function __construct(UserRepository $userDataSource)
    {
        $this->userDataSource = $userDataSource;
    }

    /**
     * @return Wallet[]
     */
    public function execute(string $user_id): array
    {
        $users = $this->userDataSource->getAll();

        return array_filter($users, function ($user) {
            return ($user->getId() % 2 == 0 || $user->getId() % 5 == 0);
        });
    }
}
