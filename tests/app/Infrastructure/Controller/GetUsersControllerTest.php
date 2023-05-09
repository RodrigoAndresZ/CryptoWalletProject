<?php

namespace Tests\app\Infrastructure\Controller;

use App\Application\UserDataSource\UserDataSource;
use App\Domain\User;
use Mockery;
use Tests\TestCase;

class GetUsersControllerTest extends Testcase
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
    public function listOfUsersEmpty()
    {
        $this->userDataSource
            ->expects('getAll')
            ->andReturnNull();
        $response = $this->get('/api/users');
        $response->assertExactJson([]);
    }


    /**
     * @test
     */
    public function listOfUsersNoEmpty()
    {
        $this->userDataSource
            ->expects('getAll')
            ->andReturn([new User(1, 'email@email.com'), new User(2, 'another_email@email.com')]);

        $response = $this->get('/api/users');

        $response->assertOk();
        $response->assertExactJson([['id' => '1', 'email' => 'email@email.com'],['id' => '2', 'email' => 'another_email@email.com']]);
    }
}
