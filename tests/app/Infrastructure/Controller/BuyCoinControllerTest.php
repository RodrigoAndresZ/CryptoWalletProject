<?php

namespace Tests\app\Infrastructure\Controller;

use Mockery;
use App\Application\DataSource\CoinDataSource;
use Tests\TestCase;
use App\Domain\Coin;
use App\Infrastructure\Persistence\CoinLoreDataSource;

class BuyCoinControllerTest extends TestCase
{
    private CoinDataSource $coinDataSource;

    /**
     * @setUp
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->coinDataSource = $this->mock(CoinDataSource::class);
        $this->app->bind(CoinDataSource::class, CoinLoreDataSource::class, function () {
            return $this->coinDataSource;
        });
    }


    /**
     * @test
     */

    public function givenCoinIdIsCorrect()
    {

        $this->coinDataSource
            ->shouldReceive('getCoinByName')
            ->with('Bitcoin');


        $response = $this->post('/api/coin/buy/{id}/{id2}', [
            'id' => 'Bitcoin',

        ]);

        $response->assertOk();
        $response->assertExactJson(['coin_id' => '90','name' => 'Bitcoin','symbol' => 'BTC']);
    }



    /**
     * @test
     */
    public function givenCoinIdIsNotCorrect()
    {
        $this->coinDataSource
            ->shouldReceive('getCoinByName')
            ->with('Bitcoin');



        $response = $this->post('/api/coin/buy/{id}/{id2}', [
            'id' => 'UpnaCoin',

        ]);

        $response->assertNotFound();
        $response->assertExactJson(['error' => 'La coin no existe']);
    }
}
