<?php

namespace App\Application\DataSource;

use App\Domain\Coin;

interface CoinDataSource
{
    public function getCoinByName(string $coin_id): ?Coin;
}
