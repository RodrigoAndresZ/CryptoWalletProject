<?php

namespace App\Application\DataSource;

use App\Domain\Coin;
use App\Domain\Wallet;

interface WalletDataSource
{
    public function createWallet(): ?string;


    public function findWalletById(string $wallet_id): ?Wallet;


    public function addCoinInWallet(string $walletId, Coin $coin): void;
}
