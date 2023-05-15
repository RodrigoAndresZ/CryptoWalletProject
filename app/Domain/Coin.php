<?php

namespace App\Domain;

class Coin
{
    private string $coin_id;
    private string $wallet_id;

    private float $amount_usd;

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

    /**
     * @return int
     *
     * 200 - successful operation
     * 400 - bad request error
     * 404 - A coin with the specified ID was not found.
     *
     */

    public function buy(string $coin_id, string $wallet_id, float $amount_usd): float
    {
        $this->amount_usd += $amount_usd;
        return $this->amount_usd;
    }


    /**
     * @return int
     *
     * 200 - successful operation
     * 400 - bad request error
     * 404 - A coin with the specified ID was not found.
     *
     */

    public function sell(string $coin_id, string $wallet_id, float $amount_usd): int
    {
        $this->amount_usd -= $amount_usd;
        return $this->amount_usd;
    }

}
