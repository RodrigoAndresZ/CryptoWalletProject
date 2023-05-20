<?php

namespace app\Infrastructure\Persistence\CacheWalletDataSource;

use App\Application\WalletDataSource\WalletRepository;
use App\Domain\Coin;
use App\Domain\Wallet;
use App\Infrastructure\Persistence\CacheWalletDataSource\CacheWalletRepository;
use Mockery;
use Tests\TestCase;

class CacheWalletRepositoryTest extends TestCase
{
    private WalletRepository $walletRepository;

    protected function setUp(): void
    {
        $this->walletRepository = new CacheWalletRepository();
    }

    /**
     * @test
     */
    public function createWalletTest()
    {
        $expect = new Wallet(1, 1, []);
        ;

        $wallet = $this->walletRepository->create('1');

        $this->assertInstanceOf(Wallet::class, $wallet);
        $this->assertEquals($expect, $wallet);
    }

    /**
     * @test
     */
    public function getsWalletNoWalletIdTest()
    {
        $coin_id = '90';
        $coins = new Coin($coin_id, 'BTC', 'Bitcoin', 0, 30000);
        $expect = new Wallet('1', '1', [
            $coins
        ]);

        $wallet = $this->walletRepository->findWalletById('2');

        $this->assertInstanceOf(Wallet::class, $wallet);
        $this->assertEquals($expect, $wallet);
    }

    /**
     * @test
     */
    public function getsWalletTest()
    {
        $coin_id = '90';
        $coins = new Coin($coin_id, 'BTC', 'Bitcoin', 0, 30000);
        $expect = new Wallet('1', '1', [
            $coins
        ]);

        $wallet = $this->walletRepository->findWalletById('1');

        $this->assertInstanceOf(Wallet::class, $wallet);
        $this->assertEquals($expect, $wallet);
    }
}
