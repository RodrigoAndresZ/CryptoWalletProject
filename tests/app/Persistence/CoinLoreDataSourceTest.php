<?php

namespace Tests\app\Persistence;

use App\Domain\Coin;
use App\Infrastructure\Persistence\CoinLoreDataSource;
use Mockery;
use Tests\TestCase;

class CoinLoreDataSourceTest extends TestCase
{
    private CoinLoreDataSource $coinLoreDataSource;

    protected function setUp(): void
    {
        parent::setUp();
        $this->coinLoreDataSource = new CoinLoreDataSource();
    }

    /**
     * @test
     */
    public function getNullCoinByNotExistIdCoinTest()
    {
        $coin_id = 99999;
        $amount_usd = 1;

        $result = $this->coinLoreDataSource->getCoinByName($coin_id, $amount_usd);

        $this->assertNull($result);
    }

    /**
     * @test
     */
    public function getCoinByIdNameTest()
    {
        $coin_id = 90;
        $amount_usd = 1;

        $result = $this->coinLoreDataSource->getCoinByName($coin_id, $amount_usd);
        $result = $result->getJson();
        $result_amount_usd = $result['amount'] * $result['value_usd'];

        $this->assertNotNull($result);
        $this->assertIsArray($result);
        $this->assertEquals($coin_id, $result['coin_id']);
        $this->assertEquals('BTC', $result['symbol']);
        $this->assertEquals('Bitcoin', $result['name']);
        $this->assertEqualsWithDelta($amount_usd, $result_amount_usd, 0.0001);
        $this->assertIsFloat($result['value_usd']);
    }

    /**
     * @test
     */
    public function getNullActualCoinValueByNotExistIdTest()
    {
        $coin_id = 99999;

        $result = $this->coinLoreDataSource->getActualValue($coin_id);

        $this->assertNull($result);
    }

    /**
     * @test
     */
    public function getActualCoinValueByIdTest()
    {
        $coin_id = 90;

        $result = $this->coinLoreDataSource->getActualValue($coin_id);

        $this->assertNotNull($result);
        $this->assertIsFloat($result);
    }
}
