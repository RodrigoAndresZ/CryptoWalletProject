<?php

namespace app\Application;

use App\Application\UserDataSource\UserRepository;
use App\Application\WalletDataSource\WalletRepository;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use Tests\TestCase;

class CreateWalletServiceTest extends TestCase
{
    private UserRepository $userRepository;
    private WalletRepository $walletRepository;
    private CreateWalletService $createWalletService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository = $this->mock(UserRepository::class);
        $this->walletRepository = $this->mock(WalletRepository::class);
        $this->createWalletService = new CreateWalletService($this->userRepository, $this->walletRepository);
        /*

                $this->app->bind(CreateWalletService::class,  function () {
            return $this->createWalletService;
        });

         */
    }
}
