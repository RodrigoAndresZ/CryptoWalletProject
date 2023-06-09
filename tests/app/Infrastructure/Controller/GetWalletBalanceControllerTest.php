<?php

namespace Tests\app\Infrastructure\Controller;

use App\Application\DataSource\CoinDataSource;
use App\Application\DataSource\WalletDataSource;
use App\Domain\Coin;
use App\Domain\Wallet;
use Tests\TestCase;

class GetWalletBalanceControllerTest extends TestCase
{
    private WalletDataSource $walletRepository;
    private CoinDataSource $coinDataSource;

    protected function setUp(): void
    {
        parent::setUp();
        $this->walletRepository = $this->mock(WalletDataSource::class);
        $this->app->bind(WalletDataSource::class, function () {
            return $this->walletRepository;
        });
        $this->coinDataSource = $this->mock(CoinDataSource::class);
        $this->app->bind(CoinDataSource::class, function () {
            return $this->coinDataSource;
        });
    }

    /**
     * @test
     */
    public function getWalletBalanceNoWalletIdTest()
    {
        $wallet_id = "2";

        $this->walletRepository
            ->expects('findWalletById')
            ->with($wallet_id)
            ->andReturn(null);

        $response = $this->get("/api/wallet/$wallet_id/balance");
        $response->assertNotFound();
        $response->assertExactJson(['error' => 'cartera no encontrado']);
    }

    /**
     * @test
     */
    public function getWalletBalanceTest()
    {
        // probar con numero de coins
        $wallet_id = '1';
        $coin_id = '90';
        $coins = new Coin($coin_id, 'BTC', 'Bitcoin', 30000, 1);
        $coin_id2 = '80';
        $coins2 = new Coin($coin_id2, 'ETH', 'Ethereum', 1500, 2);

        $test_wallet = new Wallet('1');
        $test_wallet->setCoins(array($coins,$coins2));
        $this->walletRepository
            ->expects('findWalletById')
            ->with($wallet_id)
            ->andReturn($test_wallet);

        $this->walletRepository
            ->expects('getWalletDataById')
            ->with($wallet_id)
            ->andReturn([
                "coins" => [
                    $coins->getJson(),
                    $coins2->getJson()
                ],
                "wallet_id" => "wallet_" . $wallet_id
            ]);

        $this->coinDataSource
            ->expects('getActualValue')
            ->with($coin_id)
            ->andReturn(31000);
        $this->coinDataSource
            ->expects('getActualValue')
            ->with($coin_id2)
            ->andReturn(1800);

        $response = $this->get("/api/wallet/$wallet_id/balance");
        $response->assertOk();
        $response->assertExactJson([
            "balance_usd" => 1600
        ]);
    }
}
