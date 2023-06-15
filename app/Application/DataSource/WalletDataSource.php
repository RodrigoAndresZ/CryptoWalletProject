<?php

namespace App\Application\DataSource;

use App\Domain\Coin;
use App\Domain\Wallet;

interface WalletDataSource
{
    public function createWallet(): ?string;

    public function findWalletById(string $wallet_id): ?Wallet;

    public function addCoinToWallet(string $walletId, Coin $coin): void;

    public function sellCoinWallet(string $wallet_id, Coin $coin, float $newUsdValue, string $amountUsd): void;

    public function getWalletDataById(string $wallet_id): ?array;
}
