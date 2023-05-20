<?php

namespace app\Infrastructure\Persistence\CacheWalletDataSource;

use App\Application\WalletDataSource\WalletRepository;
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
        $expect = new Wallet(1, 1, 1, 1, 1, 1, 1, 1);;

        $user = $this->walletRepository->create('1');

        $this->assertInstanceOf(Wallet::class, $user);
        $this->assertEquals($expect, $user);
    }

    /**
     * @test
     */
    public function getsWalletTest()
    {
        $expect = new Wallet(1, 1, 1, 1, 1, 1, 1, 1);;

        $user = $this->walletRepository->findWalletById('1');

        $this->assertInstanceOf(Wallet::class, $user);
        $this->assertEquals($expect, $user);
    }
}
