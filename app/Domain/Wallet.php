<?php

namespace App\Domain;

class Wallet
{
    private string $user_id;
    private string $wallet_id;
    private array $coins;


    public function __construct(string $wallet_id)
    {
        $this->wallet_id = $wallet_id;
        $this->coins = [];
    }

    public function getUserId(): string
    {
        return $this->user_id;
    }
    public function getWalletId(): string
    {
        return $this->wallet_id;
    }

    /**
     * @param array $coins
     */
    public function setCoins(array $coins): void
    {
        $this->coins = $coins;
    }
    public function getCoins(): array
    {
        $CoinsJson = [];
        foreach ($this->coins as $coin) {
            array_push($CoinsJson, $coin->getJson());
        }

        return $CoinsJson;
    }

    public function getBalance(): float
    {
        $balance = 0;
        foreach ($this->getCoins() as $coinJson) {
            $balance += $coinJson['amount'] * $coinJson['value_usd'];
        }
        return $balance;
    }
    public function addCoin(Coin $coin): void
    {
        array_push($this->coins, $coin);
    }

    public function updateCoin(Coin $coin): void
    {
        for ($i = 0; $i < sizeof($this->coins); $i++) {
            if ($this->coins[$i]->getCoinId() == $coin->getCoinId()) {
                $this->coins[$i] = $coin;
                return;
            }
        }
        return;
    }
}
