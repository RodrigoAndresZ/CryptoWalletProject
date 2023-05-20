<?php

namespace app\Application;

use App\Application\Exceptions\UserNotFoundException;
use App\Application\UserDataSource\UserRepository;
use App\Application\WalletDataSource\WalletRepository;
use App\Application\CreateWalletService;
use App\Domain\User;
use App\Domain\Wallet;
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
    }

    /**
     * @test
     */
    public function createWalletServiceNoUserTest()
    {
        $user_id = '99';

        $this->userRepository
            ->expects('findUserById')
            ->with($user_id)
            ->andReturnNull();

        $this->expectException(UserNotFoundException::class);
        $user = $this->createWalletService->execute($user_id);
    }

    /**
     * @test
     */
    public function createWalletFromServiceUserTest()
    {
        $user_id = '1';
        $this->userRepository
            ->expects('findUserById')
            ->with($user_id)
            ->andReturn(new User(1, "email@email.com"));

        $wallet_id = "1";
        $wallet = new Wallet(1, 1, []);
        $this->walletRepository
            ->expects('create')
            ->with($user_id)
            ->andReturn($wallet);

        $result = $this->createWalletService->execute($user_id);

        $this->assertEquals($wallet_id, $result);
    }
}
