<?php

namespace Tests\app\Infrastructure\Controller;

use App\Application\DataSource\WalletDataSource;
use App\Domain\Coin;
use App\Domain\Wallet;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Tests\TestCase;

class GetWalletControllerTest extends TestCase
{
    private WalletDataSource $walletRepository;
    protected CacheRepository $cache;

    protected function setUp(): void
    {
        parent::setUp();
        $this->walletRepository = $this->mock(WalletDataSource::class);
        $this->app->bind(WalletDataSource::class, function () {
            return $this->walletRepository;
        });
        $this->cache = $this->app->make(CacheRepository::class);
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

        $wallet = new Wallet('wallet_' . $wallet_id);
        $wallet = $wallet->getJson();
        $this->cache->put('wallet_' . $wallet_id, $wallet);

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

        $wallet = new Wallet('wallet_' . $wallet_id);
        $wallet->addCoin($coin);
        $wallet = $wallet->getJson();
        $this->cache->put('wallet_' . $wallet_id, $wallet);

        $response = $this->get("/api/wallet/$wallet_id");
        $response->assertOk();
        $response->assertExactJson([[
            "amount" => 1,
            "coin_id" =>  "90",
            "name" => "Bitcoin",
            "symbol" => "BTC",
            "value_usd" => 30000
        ]]);
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

        $wallet = new Wallet('wallet_' . $wallet_id);
        $wallet->addCoin($coin);
        $wallet->addCoin($coin2);
        $wallet = $wallet->getJson();
        $this->cache->put('wallet_' . $wallet_id, $wallet);

        $response = $this->get("/api/wallet/$wallet_id");
        $response->assertOk();
        $response->assertExactJson([[
                "amount" => 1,
                "coin_id" =>  "90",
                "name" => "Bitcoin",
                "symbol" => "BTC",
                "value_usd" => 30000
            ],
            [
                "amount" => 3,
                "coin_id" =>  "80",
                "name" => "Ethereum",
                "symbol" => "ETH",
                "value_usd" => 1500
            ]
        ]);
    }
}
