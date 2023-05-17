<?php

namespace App\Domain;

class Wallet
{
    private string $user_id;
    private string $wallet_id;
    private string $coin_id;

    private string $name;
    private string $symbol;
    private float $amount;
    private float $value_usd;
    private float $balance_usd;

    public function __construct(
        string $user_id,
        string $wallet_id,
        string $coin_id,
        string $name,
        string $symbol,
        float $amount,
        float $value_usd,
        float $balance_usd
    ) {
        $this->user_id = $user_id;
        $this->wallet_id = $wallet_id;
        $this->coin_id = $coin_id;
        $this->name = $name;
        $this->symbol = $symbol;
        $this->amount = $amount;
        $this->value_usd = $value_usd;
        $this->balance_usd = $balance_usd;
    }


    public function getUserId(): string
    {
        return $this->user_id;
    }
    public function getWalletId(): string
    {
        return $this->wallet_id;
    }

    public function getCoinId(): string
    {
        return $this->coin_id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }
    public function getAmount(): float
    {
        return $this->amount;
    }
    public function getValueUsd(): float
    {
        return $this->value_usd;
    }
    public function getBalanceUsd(): float
    {
        return $this->balance_usd;
    }
}
