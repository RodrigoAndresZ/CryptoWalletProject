<?php

namespace App\Application;

use App\Application\DataSource\CoinDataSource;
use App\Domain\Coin;

class BuyCoinService
{
    private CoinDataSource $coinDataSource;

    /**
     * @param CoinDataSource $coinDataSource
     */
    public function __construct(CoinDataSource $coinDataSource)
    {
        $this->coinDataSource = $coinDataSource;
    }

    public function execute(string $coinId, float $amount): ?Coin
    {
        return $this->coinDataSource->getCoinByName($coinId, $amount);
    }
}
