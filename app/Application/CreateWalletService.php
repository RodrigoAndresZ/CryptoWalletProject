<?php

namespace App\Application;

use App\Application\DataSource\WalletDataSource;
use App\Application\Exceptions\UserNotFoundException;
use App\Application\DataSource\CoinDataSource;
use App\Application\DataSource\UserDataSource;
use App\Domain\Wallet;
use App\Domain\Coin;

class CreateWalletService
{
    private WalletDataSource $WalletDataSource;

    public function __construct(WalletDataSource $WalletDataSource)
    {

        $this->WalletDataSource = $WalletDataSource;
    }


    public function executeCreateWallet(): ?string
    {
        $wallet = $this->WalletDataSource->createWallet();
        return $wallet;
    }

    public function executefindWalletById(string $wallet_id): ?Wallet
    {
        $wallet = $this->WalletDataSource->findWalletById($wallet_id);
        return $wallet;
    }
    public function executeAddCoinInWallet(string $wallet_id, Coin $coin): void
    {
        $this->WalletDataSource->addCoinInWallet($wallet_id, $coin);
    }
}
