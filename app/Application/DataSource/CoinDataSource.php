<?php

namespace App\Application\DataSource;

use App\Domain\Coin;

interface CoinDataSource
{
    public function getCoinByName(string $coin_id, float $amount_usd): ?Coin;

    public function getActualValue(string $coin_id): ?float;
}
