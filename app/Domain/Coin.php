<?php

namespace App\Domain;

class Coin
{
    private string $coin_id;
    private string $wallet_id;



    private double $amount_usd;

    /**
     * @param string $coin_id
     * @param string $wallet_id
     * @param float $amount_usd
     */
    public function __construct(string $coin_id, string $wallet_id, float $amount_usd)
    {
        $this->coin_id = $coin_id;
        $this->wallet_id = $wallet_id;
        $this->amount_usd = $amount_usd;
    }

    /**
     * @return string
     */
    public function getCoinId(): string
    {
        return $this->coin_id;
    }

    /**
     * @return string
     */
    public function getWalletId(): string
    {
        return $this->wallet_id;
    }

    /**
     * @return float
     */
    public function getAmountUsd(): float
    {
        return $this->amount_usd;
    }
}
