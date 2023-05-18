<?php

namespace App\Infrastructure\Persistence\CacheWalletDataSource;

use App\Application\WalletDataSource\WalletRepository;
use App\Domain\Wallet;

class CacheWalletRepository implements WalletRepository
{
    public function create(string $user_id): ?Wallet
    {
        return new Wallet(1, 1, 1, 1, 1, 1, 1, 1);
    }

    public function findWalletById(string $wallet_id): ?Wallet
    {
        //return Cache::get($wallet_id);
        return new Wallet(1, $wallet_id, 1, 1, 1, 1, 1, 1);
    }
}
