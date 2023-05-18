<?php

namespace App\Application;

use App\Application\Exceptions\UserNotFoundException;
use App\Application\UserDataSource\UserRepository;
use App\Application\WalletDataSource\WalletRepository;
use App\Domain\User;
use App\Domain\Wallet;
use App\Infrastructure\Persistence\CacheUserDataSource\CacheUserRepository;
use App\Infrastructure\Persistence\CacheWalletDataSource\CacheWalletRepository;

class CreateWalletService
{
    private UserRepository $UserRepository;
    private WalletRepository $WalletRepository;

    public function __construct(UserRepository $UserRepository, WalletRepository $WalletRepository)
    {
        $this->UserRepository = $UserRepository;
        $this->WalletRepository = $WalletRepository;
    }


    /**
     * @throws UserNotFoundException
     */
    public function execute(string $user_id): wallet
    {
        $user = $this->UserRepository->findUserById($user_id);
        if (is_null($user)) {
            throw new UserNotFoundException();
        }

        $wallet = $this->WalletRepository->create($user_id);



        return $wallet ;
    }
}
