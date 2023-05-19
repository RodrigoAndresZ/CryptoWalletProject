<?php

namespace Tests\app\Infrastructure\Persistence\CacheUserDataSource;

use App\Application\UserDataSource\UserRepository;
use App\Domain\User;
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
    public function userWithGivenUserIdDoesNotExist()
    {

        $this->userDataSource
            ->expects('findByUserId')
            ->with('1')
            ->andReturnNull();

        $response = $this->get('/api/users/email@email.com');

        //$response->assertNotFound();
        $response->assertExactJson(['error' => 'usuario no encontrado']);
    }



    /**
     * @test
     */
    public function userWithGivenEmailDoesNotExist()
    {

        $this->userDataSource
            ->expects('findByEmail')
            ->with('email@email.com')
            ->andReturnNull();

        $response = $this->get('/api/users/email@email.com');

        //$response->assertNotFound();
        $response->assertExactJson(['error' => 'usuario no encontrado']);
    }


    /**
     * @test
     */
    public function getsUserTest()
    {

        $this->userDataSource
            ->expects('findByUserId')
            ->with('1')
            ->andReturn(new User(1, 'email@email.com'));

        $response = $this->get('/api/user/1');

        $response->assertOk();
        $response->assertExactJson(['id' => 1, 'email' => 'email@email.com']);
    }


    /**
     * @test
     */
    public function getsUserByIdTest()
    {

        $this->userDataSource
            ->expects('findByEmail')
            ->with('email@email.com')
            ->andReturn(new User(1, 'email@email.com'));

        $response = $this->get('/api/users/email@email.com');

        $response->assertOk();
        $response->assertExactJson(['id' => 1, 'email' => 'email@email.com']);
    }
}
