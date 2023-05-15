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
        $coin = new Coin(1,1,0);

        $result = $coin->buy(1,1,100);

        $this->assertEquals(200, $result);
    }


}
