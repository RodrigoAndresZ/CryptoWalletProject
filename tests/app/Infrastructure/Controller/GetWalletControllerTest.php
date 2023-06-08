<?php

namespace Tests\app\Infrastructure\Controller;

use App\Application\DataSource\WalletDataSource;
use App\Domain\Coin;
use App\Domain\Wallet;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Tests\TestCase;
use Mockery;

class GetWalletControllerTest extends TestCase
{
    private WalletDataSource $walletRepository;

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->walletRepository = Mockery::mock(WalletDataSource::class);
        $this->app->bind(WalletDataSource::class, function () {
            return $this->walletRepository;
        });
    }

    /**
     * @test
     */
    public function getWalletNoWalletIdTest()
    {
        $wallet_id = "2";

        $this->walletRepository
            ->expects('findWalletById')
            ->with($wallet_id)
            ->andReturn(null);

        $response = $this->get("/api/wallet/$wallet_id");
        $response->assertNotFound();
        $response->assertExactJson(['error' => 'cartera no encontrado']);
    }

    /**
     * @test
     */
    public function getEmptyWalletTest()
    {
        $wallet_id = '1';

        $this->walletRepository
            ->expects('findWalletById')
            ->with($wallet_id)
            ->andReturn(new Wallet(
                '1'
            ));

        $this->walletRepository
            ->expects('getWalletById')
            ->with($wallet_id)
            ->andReturn([
                "coins" => [],
                "wallet_id" => "wallet_" . $wallet_id
            ]);

        $response = $this->get("/api/wallet/$wallet_id");
        $response->assertOk();
        $response->assertExactJson([]);
    }

    /**
     * @test
     */
    public function getOneCoinWalletTest()
    {
        $wallet_id = '1';
        $coin = new Coin(90, 'BTC', 'Bitcoin', 30000, 1);

        $this->walletRepository
            ->expects('findWalletById')
            ->with($wallet_id)
            ->andReturn(new Wallet(
                '1'
            ));

        $this->walletRepository
            ->expects('getWalletById')
            ->with($wallet_id)
            ->andReturn([
                "coins" => [
                    $coin->getJson()
                ],
                "wallet_id" => "wallet_" . $wallet_id
            ]);

        $response = $this->get("/api/wallet/$wallet_id");
        $response->assertOk();
        $response->assertExactJson([
            $coin->getJson()
        ]);
    }

    /**
     * @test
     */
    public function getMoreThanOneCoinWalletTest()
    {
        $wallet_id = '1';
        $coin = new Coin(90, 'BTC', 'Bitcoin', 30000, 1);
        $coin2 = new Coin(80, 'ETH', 'Ethereum', 1500, 3);

        $this->walletRepository
            ->expects('findWalletById')
            ->with($wallet_id)
            ->andReturn(new Wallet(
                '1'
            ));

        $this->walletRepository
            ->expects('getWalletById')
            ->with($wallet_id)
            ->andReturn([
                "coins" => [
                    $coin->getJson(),
                    $coin2->getJson()
                ],
                "wallet_id" => "wallet_" . $wallet_id
            ]);

        $response = $this->get("/api/wallet/$wallet_id");
        $response->assertOk();
        $response->assertExactJson([
            $coin->getJson(),
            $coin2->getJson()
        ]);
    }
}
