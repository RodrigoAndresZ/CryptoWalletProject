<?php

namespace app\Infrastructure\Controller;

use App\Application\CreateWalletService;
use App\Application\UserDataSource\UserRepository;
use App\Application\WalletDataSource\WalletRepository;
use App\Domain\User;
use App\Domain\Wallet;
use App\Infrastructure\Persistence\CreateWalletController;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
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

        // $this->createWalletService = new CreateWalletService($this->userRepository, $this->walletRepository );
    }

    /**
     * @test
     */
    public function createWalletFromRequestBadParametersTest()
    {
        $user_id = ["User_id" => "1"];

        $response = $this->postJson('/api/wallet/open', $user_id);

        $response->assertStatus(400);
        $response->assertExactJson(['error' => 'parámetros incorrectos']);
    }


    /**
     * @test
     */
    public function createWalletFromRequestNoUserTest()
    {
        $user_id = ["user_id" => "1"];

        $this->userRepository
            ->expects('findUserById')
            ->with('1')
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


        $response = $this->postJson('/api/wallet/open', $user_id);

        //$response->assertStatus();
        $response->assertExactJson(['error' => 'parámetros incorrectos']);
    }
}
