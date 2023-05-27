<?php
namespace App\Application;

use App\Application\DataSource\CoinDataSource;
use App\Domain\Coin;

class SellCoinService
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

    public function executeActualPrice(string $coin_id): ?float
    {
        return $this->coinDataSource->getActualValue($coin_id);
    }


}
