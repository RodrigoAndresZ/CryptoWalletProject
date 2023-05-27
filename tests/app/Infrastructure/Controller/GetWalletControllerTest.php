<?php

namespace Tests\app\Infrastructure\Controller;

use App\Application\DataSource\WalletDataSource;
use App\Domain\Coin;
use App\Domain\Wallet;
use Tests\TestCase;

class GetWalletControllerTest extends TestCase
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
    public function getWalletTest()
    {
        $wallet_id = '1';
        $coin = new Coin(90, 'BTC', 'Bitcoin', 0, 30000);

        $this->walletRepository
            ->expects('findWalletById')
            ->with($wallet_id)
            ->andReturn(new Wallet(
                '1'
            ));

        $response = $this->get("/api/wallet/$wallet_id");
        $response->assertOk();
        $response->assertExactJson([]);
    }
}
