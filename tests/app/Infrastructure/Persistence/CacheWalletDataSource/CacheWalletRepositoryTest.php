<?php

namespace app\Infrastructure\Persistence\CacheWalletDataSource;

use App\Application\WalletDataSource\WalletRepository;
use App\Domain\Wallet;
use Mockery;
use Tests\TestCase;

class CacheWalletRepositoryTest extends TestCase
{
    private WalletRepository $walletRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->walletRepository = $this->mock(WalletRepository::class);

        $this->app->bind(WalletRepository::class, function () {
            return $this->walletRepository;
        });
    }

    /**
     * @test
     */
    public function getsWalletTest()
    {

        $this->walletRepository
            ->expects('findWalletById')
            ->with('1')
            ->andReturn(new Wallet(1, 1, 1, 1, 1, 1, 1, 1));

        $response = $this->get('/api/wallet/1');

//        $response->assertOk();
        $response->assertExactJson(['user_id' => '1',
            'wallet_id' => '1',
            'coin_id' => '1',
            'name' => '1',
            'symbol' => '1',
            'amount' => 1,
            'value_usd' => 1,
            'balance_usd' => 1]);
    }
}
