<?php

namespace App\Infrastructure\Persistence\CacheWalletDataSource;

use App\Application\WalletDataSource\WalletRepository;
use App\Domain\Wallet;

class CacheWalletRepository implements WalletRepository
{
    public function create(string $user_id): ?Wallet
    {
        // TODO: Implement create() method.
    }
}
