<?php

namespace app\Infrastructure\Controller;

use App\Application\Exceptions\UserNotFoundException;
use App\Application\UserDataSource\UserRepository;
use App\Application\WalletDataSource\WalletRepository;
use App\Domain\User;
use App\Domain\Wallet;
use Tests\TestCase;

class CreateWalletControllerTest extends TestCase
{
    private UserRepository $userRepository;
    private WalletRepository $walletRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository = $this->mock(UserRepository::class);
        $this->app->bind(UserRepository::class, function () {
            return $this->userRepository;
        });

        $this->walletRepository = $this->mock(WalletRepository::class);
        $this->app->bind(WalletRepository::class, function () {
            return $this->walletRepository;
        });
    }

    /**
     * @test
     */
    public function createWalletFromRequestBadParametersTest()
    {
        $json = ["Pepe" => "asas"];

        $response = $this->postJson('/api/wallet/open', $json);

        $response->assertBadRequest();
        $response->assertExactJson(['error' => 'parámetros incorrectos']);
    }

    /**
     * @test
     */
    public function createWalletFromRequestNoUserTest()
    {
        $user_id = "99";
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
            ->andReturn(new User(1, "email@email.com"));

        $this->walletRepository
            ->expects('create')
            ->with('1')
            ->andReturn(new Wallet(
                1,
                1,
                1,
                1,
                1,
                1,
                1,
                1
            ));

        $response = $this->postJson('/api/wallet/open', $json);

        $response->assertOk();
        $response->assertExactJson(['wallet_id' => '1']);
    }
}
