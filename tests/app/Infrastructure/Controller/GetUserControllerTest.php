<?php

namespace Tests\app\Infrastructure\Controller;

use App\Application\UserDataSource\UserDataSource;
use App\Domain\User;
use Mockery;
use Tests\TestCase;

class GetUserControllerTest extends TestCase
{
    private UserDataSource $userDataSource;

    /**
     * @setUp
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->userDataSource = Mockery::mock(UserDataSource::class);
        $this->app->bind(UserDataSource::class, function () {
            return $this->userDataSource;
        });
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

        $response->assertNotFound();
        $response->assertExactJson(['error' => 'usuario no encontrado']);
    }

    /**
     * @test
     */
    public function getsUser()
    {
        $this->userDataSource
            ->expects('findByEmail')
            ->with('email@email.com')
            ->andReturn(new User(1,'email@email.com'));

        $response = $this->get('/api/users/email@email.com');

        $response->assertOk();
        $response->assertExactJson(['id' => 1, 'email' => 'email@email.com']);
    }
}
