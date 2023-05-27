<?php

namespace app\Infrastructure\Controller;

use App\Application\DataSource\UserDataSource;
use App\Application\DataSource\WalletDataSource;
use App\Application\UserDataSource\UserRepository;
use App\Infrastructure\Persistence\CacheUserDataSource\CacheUserRepository;
use App\Infrastructure\Persistence\CacheWalletDataSource\CacheWalletDataSource;
use App\Domain\User;
use App\Domain\Wallet;
use App\Infrastructure\Persistence\FileUserDataSource;
use Tests\TestCase;
use Mockery;

class CreateWalletControllerTest extends TestCase
{
    private UserDataSource $userRepository;
    private WalletDataSource $walletDataSource;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository = $this->mock(UserDataSource::class);
        $this->app->bind(UserDataSource::class, function () {
            return $this->userRepository;
        });

        $this->walletDataSource = $this->mock(WalletDataSource::class);
        $this->app->bind(WalletDataSource::class, CacheWalletDataSource::class, function () {
            return $this->walletDataSource;
        });
    }

    /**
     * @test
     */
    public function createWalletFromRequestBadParametersNoUserIdTest()
    {
        $json = ["Pepe" => "asas"];

        $response = $this->postJson('/api/wallet/open', $json);

        $response->assertExactJson([
            "message" => 'El campo user_id es requerido.',
            'errors' => [
                'user_id' => ['El campo user_id es requerido.']
            ]
        ]);
    }

    /**
     * @test
     */
    public function createWalletFromRequestBadParametersNoStringTest()
    {
        $json = ["user_id" => 1];

        $response = $this->postJson('/api/wallet/open', $json);

        $response->assertExactJson([
            "message" => 'El campo user_id debe ser un string.',
            'errors' => [
                'user_id' => ['El campo user_id debe ser un string.']
            ]
        ]);
    }

    /**
     * @test
     */
    public function createWalletFromRequestNoUserTest()
    {
        $user_id = '99';
        $json = ["user_id" => $user_id];

        $this->userRepository
            ->expects('findUserById')
            ->with($user_id)
            ->andReturn(null);

        $response = $this->postJson('/api/wallet/open', $json);

        $response->assertNotFound();
        $response->assertExactJson(['error' => 'usuario no encontrado']);
    }

    /**
     * @test
     */
    public function createWalletFromRequestUserTest()
    {
        $user_id = "1";
        $json = ["user_id" => $user_id];

        $this->userRepository
            ->expects('findUserById')
            ->with($user_id)
            ->andReturn(new User(1));



        $response = $this->postJson('/api/wallet/open', $json);

        $response->assertOk();
        $response->assertExactJson(['exito' => 'wallet creada correctamente','wallet_id' => 'wallet_0']);
    }
}
