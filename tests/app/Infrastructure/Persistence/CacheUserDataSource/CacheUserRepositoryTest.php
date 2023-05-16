<?php

namespace app\Infrastructure\Persistence\CacheUserDataSource;

use App\Application\UserDataSource\UserRepository;
use App\Domain\User;
use Mockery;
use Tests\TestCase;

class CacheUserRepositoryTest extends TestCase
{
    private UserRepository $userDataSource;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userDataSource = $this->mock(UserRepository::class);
        $this->app->bind(UserRepository::class, function () {
            return $this->userDataSource;
        });
    }



    /**
     * @test
     */
    public function userWithGivenEmailDoesNotExist()
    {
        $this->userDataSource
            ->expects('findUserbyId')
            ->with('1')
            ->andReturnNull();

        $response = $this->get('/api/users/');

        $response->assertNotFound();
        $response->assertExactJson(['error' => 'usuario no encontrado']);
    }

    /**
     * @test
     */
    public function getsUser()
    {
        $this->userDataSource
            ->expects('findUserbyId')
            ->with('1')
            ->andReturn(new User(1, 'email@email.com'));

        $response = $this->get('/api/users/email@email.com');

        $response->assertOk();
        $response->assertExactJson(['id' => 2, 'email' => 'email@email.com']);
    }
}
