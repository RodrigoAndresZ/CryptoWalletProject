<?php

namespace App\Infrastructure\Service;

use App\Application\DataSource\CoinDataSource;
use Barryvdh\Debugbar\Controllers\BaseController;
use App\Infrastructure\Persistence\CoinLoreDataSource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
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
