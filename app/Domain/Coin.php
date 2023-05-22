<?php

namespace App\Domain;

class Coin
{
    private string $coin_id;

    private string $name;

    private string $symbol;

    private float $amount;

    private float $value_usd;

    public function __construct(string $coin_id, string $symbol, string $name, float $value_usd, float $amount)
    {
        $this->coin_id = $coin_id;
        $this->symbol = $symbol;
        $this->name = $name;
        $this->value_usd = $value_usd;
        $this->amount = $amount;
    }

    public function getCoinId(): string
    {
        return $this->coin_id;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }
    public function getName(): string
    {
        return $this->name;
    }

    public function getValueUsd(): float
    {
        return $this->value_usd;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }





}
