<?php

namespace Tests\app\Persistence\CacheWalletDataSourceTest;

use App\Application\DataSource\WalletDataSource;
use App\Domain\Coin;
use App\Domain\Wallet;
use App\Infrastructure\Persistence\CacheWalletDataSource\CacheWalletDataSource;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Tests\TestCase;

class CacheWalletDataSourceTest extends TestCase
{
    private WalletDataSource $walletDataSource;
    protected CacheRepository $cacheRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cacheRepository = $this->app->make(CacheRepository::class);
        $this->walletDataSource = new CacheWalletDataSource($this->cacheRepository);
    }

    /**
     * @test
     */
    public function createWalletTest()
    {
        $walletId = $this->walletDataSource->createWallet();

        $this->assertNotNull($walletId);
        $this->assertTrue($this->cacheRepository->has($walletId));
    }

    /**
     * @test
     */
    public function findNullWalletByNotExistIdTest()
    {
        $walletId = 9999;

        $wallet = $this->walletDataSource->findWalletById($walletId);

        $this->assertNull($wallet);
    }

    /**
     * @test
     */
    public function findWalletByIdTest()
    {
        $walletId = $this->walletDataSource->createWallet();
        $walletId = str_replace('wallet_', '', $walletId);

        $wallet = $this->walletDataSource->findWalletById($walletId);

        $this->assertInstanceOf(Wallet::class, $wallet);
        $this->assertEquals('wallet_' . $walletId, $wallet->getWalletId());
    }

    /**
     * @test
     */
    public function getNullWalletDataByIdTest()
    {
        $walletId = 999;
        $walletData = [
            'coins' => [],
            'wallet_id' => 'wallet_' . $walletId
        ];

        $wallet = $this->walletDataSource->getWalletDataById($walletId);
        $this->assertNull($wallet);
    }

    /**
     * @test
     */
    public function getEmptyWalletDataByIdTest()
    {
        $walletId = $this->walletDataSource->createWallet();
        $walletData = [
            'coins' => [],
            'wallet_id' => $walletId
        ];
        $walletId = str_replace('wallet_', '', $walletId);

        $wallet = $this->walletDataSource->getWalletDataById($walletId);
        $this->assertNotNull($wallet);
        $this->assertEquals($walletData, $wallet);
    }

    /**
     * @test
     */
    public function getWalletDataWithCoinsByIdTest()
    {
        $coin_id = '90';
        $coin1 = new Coin($coin_id, 'BTC', 'Bitcoin', 30000, 1);
        $coin_id2 = '80';
        $coin2 = new Coin($coin_id2, 'ETH', 'Ethereum', 1500, 2);
        $wallet_Id = $this->walletDataSource->createWallet();
        $walletData = [
            'coins' => [
                $coin1->getJson(),
                $coin2->getJson()
                ],
            'wallet_id' => $wallet_Id
        ];
        $wallet_Id = str_replace('wallet_', '', $wallet_Id);
        $this->walletDataSource->addCoinToWallet($wallet_Id, $coin1);
        $this->walletDataSource->addCoinToWallet($wallet_Id, $coin2);

        $wallet = $this->walletDataSource->getWalletDataById($wallet_Id);

        $this->assertNotNull($wallet);
        $this->assertEquals($walletData, $wallet);
        $this->assertEquals($walletData['coins'], $wallet['coins']);
        $this->assertEquals($coin1->getJson(), $wallet['coins'][0]);
        $this->assertEquals($coin2->getJson(), $wallet['coins'][1]);
    }

    /**
     * @test
     */
    public function addCoinToWalletTest()
    {
        $coin_id = '90';
        $coin1 = new Coin($coin_id, 'BTC', 'Bitcoin', 30000, 1);
        $wallet_Id = $this->walletDataSource->createWallet();
        $walletData = [
            'coins' => [
                $coin1->getJson()
            ],
            'wallet_id' => $wallet_Id
        ];
        $wallet_Id = str_replace('wallet_', '', $wallet_Id);

        $this->walletDataSource->addCoinToWallet($wallet_Id, $coin1);

        $wallet = $this->walletDataSource->getWalletDataById($wallet_Id);
        $this->assertNotNull($wallet);
        $this->assertEquals($walletData['coins'], $wallet['coins']);
        $this->assertEquals($coin1->getJson(), $wallet['coins'][0]);
    }

    /**
     * @test
     */
    public function sellCoinToWalletTest()
    {
        $coin_id = '90';
        $coin1 = new Coin($coin_id, 'BTC', 'Bitcoin', 30000, 1);
        $wallet_Id = $this->walletDataSource->createWallet();
        $wallet_Id = str_replace('wallet_', '', $wallet_Id);
        $this->walletDataSource->addCoinToWallet($wallet_Id, $coin1);
        $newUsdValue = 30000;
        $amountUsd = '30000';

        $this->walletDataSource->sellCoinWallet($wallet_Id, $coin1, $newUsdValue, $amountUsd);

        $coin1->setAmount(0);
        $wallet = $this->walletDataSource->getWalletDataById($wallet_Id);
        $this->assertNotNull($wallet);
        $this->assertEquals($coin1->getJson(), $wallet['coins'][0]);
    }
}
