<?php

namespace Tests\app\Infrastructure\Persistence\CacheUserDataSource;

use App\Application\UserDataSource\UserRepository;
use App\Domain\User;
use App\Infrastructure\Persistence\CacheUserDataSource\CacheUserRepository;
use Tests\TestCase;

class CacheUserRepositoryTest extends TestCase
{
    private UserRepository $userDataSource;

    protected function setUp(): void
    {
        $this->userDataSource = new CacheUserRepository();
    }

    /**
     * @test
     */
    public function userWithGivenUserIdDoesNotExistTest()
    {
        $expect = new User(1, "email@email.com");


        $user = $this->userDataSource->findUserById('2');

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($expect, $user);
    }

    /**
     * @test
     */
    public function userWithGivenEmailDoesNotExistTest()
    {
        $expect = new User(2, "email@email.com");

        $user = $this->userDataSource->findByEmail('em@email.com');

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($expect, $user);
    }


    /**
     * @test
     */
    public function getsUserByIdTest()
    {
        $expect = new User(1, "email@email.com");

        $user = $this->userDataSource->findUserById('1');

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($expect, $user);
    }

    /**
     * @test
     */
    public function getsUserByEmailTest()
    {
        $expect = new User(2, "email@email.com");

        $user = $this->userDataSource->findByEmail('email@email.com');

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($expect, $user);
    }
}
