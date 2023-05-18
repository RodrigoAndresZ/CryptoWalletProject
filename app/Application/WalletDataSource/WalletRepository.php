<?php

namespace App\Application\WalletDataSource;

use App\Domain\Wallet;

interface WalletRepository
{
    public function create(string $user_id): ?Wallet;

    public function findWalletById(string $wallet_id): ?Wallet;
}
