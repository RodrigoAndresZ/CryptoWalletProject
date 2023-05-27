<?php

namespace Tests\app\Infrastructure\Controller;

use App\Application\DataSource\WalletDataSource;
use Mockery;
use App\Application\DataSource\CoinDataSource;
use Tests\TestCase;
use App\Domain\Coin;
use App\Domain\Wallet;
use App\Infrastructure\Persistence\CoinLoreDataSource;

class SellCoinControllerTest extends TestCase
{
    private CoinDataSource $coinDataSource;
    private WalletDataSource $walletDataSource;


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
        $this->walletDataSource = $this->mock(WalletDataSource::class);
        $this->app->bind(WalletDataSource::class, function () {
            return $this->walletDataSource;
        });
    }


    /**
     * @test
     */

    public function givenCoinIdToSellIsCorrect()
    {
        $coin_id = 'Ethereum';
        $wallet_id = 'walletPrueba';
        $amount_usd = 0.85;

        $json = ['coin_id' => $coin_id,
            'wallet_id' => $wallet_id,
            'amount_usd' => $amount_usd];

        $this->coinDataSource
            ->shouldReceive('getCoinByName')
            ->with($coin_id, $amount_usd);


        $this->walletDataSource
            ->expects("findWalletById")
            ->with($wallet_id)
            ->andReturn(new Wallet($wallet_id));

        $this->walletDataSource
            ->expects("sellCoinWallet");

        $response = $this->postJson('/api/coin/sell', $json);

        $response->assertOk();
        $response->assertExactJson(['exito' => 'moneda vendida correctamente']);
    }

    /**
     * @test
     */
    public function ifWalletIdNotFound()
    {
        $coin_id = 'Ethereum';
        $wallet_id = 'walletPrueba';
        $amount_usd = 0.85;

        $json = ['coin_id' => $coin_id,
            'wallet_id' => $wallet_id,
            'amount_usd' => $amount_usd];

        $this->coinDataSource
            ->shouldReceive('getCoinByName')
            ->with($coin_id, $amount_usd);

        $this->walletDataSource
            ->expects("findWalletById")
            ->with($wallet_id)
            ->andReturn(null);

        $response = $this->postJson('/api/coin/sell', $json);


        $response->assertNotFound();
        $response->assertExactJson([ 'error' => 'Wallet con ese ID no fue encontrada']);
    }



    /**
     * @test
     */
    public function givenCoinIdIsNotCorrect()
    {

        $coin_id = 'UpnaCoin';
        $wallet_id = 'walletPrueba';
        $amount_usd = 0.85;

        $json = ['coin_id' => $coin_id,
            'wallet_id' => $wallet_id,
            'amount_usd' => $amount_usd];

        $this->coinDataSource
            ->shouldReceive('getCoinByName')
            ->with($coin_id, $amount_usd)
            ->andReturn(null);

        $response = $this->postJson('/api/coin/buy', $json);

        $response->assertNotFound();
        $response->assertExactJson(['error' => 'El coin id dado no existe']);
    }





    /**
     * @test
     */
    public function testBuyCoinWithMissingCoinId()
    {

        $wallet_id = 'walletPrueba';
        $amount_usd = 0.85;

        $json = ['wallet_id' => $wallet_id,
            'amount_usd' => $amount_usd];

        $response = $this->postJson('/api/coin/buy', $json);

        $response->assertExactJson([
            "message" => 'El campo coin_id es requerido.',
            'errors' => [
                'coin_id' => ['El campo coin_id es requerido.']
            ]
        ]);
    }

    /**
     * @test
     */
    public function testBuyCoinWithNoStringCoinId()
    {
        $coin_id = 12432434;
        $wallet_id = 'walletPrueba';
        $amount_usd = 0.85;

        $json = ['coin_id' => $coin_id,
            'wallet_id' => $wallet_id,
            'amount_usd' => $amount_usd];

        $response = $this->postJson('/api/coin/buy', $json);

        $response->assertExactJson([
            "message" => 'El campo coin_id debe ser un string.',
            'errors' => [
                'coin_id' => ['El campo coin_id debe ser un string.']
            ]
        ]);
    }


    /**
     * @test
     */
    public function testBuyCoinWithMissingWallet()
    {

        $coin_id = 'Bitcoin';
        $amount_usd = 0.85;

        $json = ['coin_id' => $coin_id,
            'amount_usd' => $amount_usd];

        $response = $this->postJson('/api/coin/buy', $json);

        $response->assertExactJson([
            "message" => 'El campo wallet_id es requerido.',
            'errors' => [
                'wallet_id' => ['El campo wallet_id es requerido.']
            ]
        ]);
    }


    /**
     * @test
     */
    public function testBuyCoinWithNoStringWalletId()
    {
        $coin_id = 'Bitcoin';
        $wallet_id = 42343242423;
        $amount_usd = 0.85;

        $json = ['coin_id' => $coin_id,
            'wallet_id' => $wallet_id,
            'amount_usd' => $amount_usd];

        $response = $this->postJson('/api/coin/buy', $json);

        $response->assertExactJson([
            "message" => 'El campo wallet_id debe ser un string.',
            'errors' => [
                'wallet_id' => ['El campo wallet_id debe ser un string.']
            ]
        ]);
    }


    /**
     * @test
     */
    public function testBuyCoinWithMissingAmount()
    {

        $coin_id = 'Bitcoin';
        $wallet_id = 'WalletPrueba';


        $json = ['coin_id' => $coin_id,
            'wallet_id' => $wallet_id];

        $response = $this->postJson('/api/coin/buy', $json);

        $response->assertExactJson([
            "message" => 'El campo amount_usd es requerido.',
            'errors' => [
                'amount_usd' => ['El campo amount_usd es requerido.']
            ]
        ]);
    }


    /**
     * @test
     */
    public function testBuyCoinWithNoNumberAmount()
    {

        $coin_id = 'Bitcoin';
        $wallet_id = 'WalletPurueba';
        $amount_usd = 'ochenta';

        $json = ['coin_id' => $coin_id,
            'wallet_id' => $wallet_id,
            'amount_usd' => $amount_usd];

        $response = $this->postJson('/api/coin/buy', $json);

        $response->assertExactJson([
            "message" => 'El campo amount_usd debe ser un número.',
            'errors' => [
                'amount_usd' => ['El campo amount_usd debe ser un número.']
            ]
        ]);
    }
}
