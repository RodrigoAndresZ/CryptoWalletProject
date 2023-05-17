<?php

namespace Tests;

use App\Domain\Coin;
use PHPUnit\Framework\TestCase;

final class CoinTest extends TestCase
{

    /**
     * @test
     */
    public function shouldBuyCoin()
    {
        $coin = new Coin(1,1,100);
        $toBuy = 800;

        $result = $coin->buy(1,1,$toBuy);

        $this->assertEquals(900, $result);
    }

    /**
     * @test
     */
    public function shouldSellCoin()
    {
        $coin = new Coin(1,1,700);
        $toSell = 100;

        $result = $coin->sell(1,1,$toSell);

        $this->assertEquals(600, $result);
    }


}
