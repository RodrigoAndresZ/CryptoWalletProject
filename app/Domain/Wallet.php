<?php

namespace App\Domain;

class Wallet
{
    private string $user_id;
    private string $wallet_id;
    private array $coins;

    public function __construct(
        string $user_id,
        string $wallet_id,
        array $coins
    ) {
        $this->user_id = $user_id;
        $this->wallet_id = $wallet_id;
        $this->coins = $coins;
    }


    public function getUserId(): string
    {
        return $this->user_id;
    }
    public function getWalletId(): string
    {
        return $this->wallet_id;
    }

    public function getCoins(): array
    {
        return $this->coins;
    }

    public function getBalance(): float
    {
        $balance = 0;
        foreach ($this->coins as $coin_id => $coinJson){
            $balance += $coinJson['amount'] * $coinJson['value_usd'];
        }
        return $balance;
    }
}
