<?php

namespace Tests\app\Infrastructure\Controller;

use App\Application\DataSource\WalletDataSource;
use App\Domain\Coin;
use App\Domain\Wallet;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Tests\TestCase;

class GetWalletBalanceControllerTest extends TestCase
{
    private WalletDataSource $walletRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->walletRepository = $this->mock(WalletDataSource::class);
        $this->app->bind(WalletDataSource::class, function () {
            return $this->walletRepository;
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
            ->expects('getWalletById')
            ->with($wallet_id)
            ->andReturn([
                "coins" => [
                    $coins->getJson(),
                    $coins2->getJson()
                ],
                "wallet_id" => "wallet_" . $wallet_id
            ]);

        $response = $this->get("/api/wallet/$wallet_id/balance");
        $response->assertOk();
        $response->assertExactJson([
            "balance_usd" => 33000
        ]);
    }
}
