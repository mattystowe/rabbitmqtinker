<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Application\User\Factory\UserFactory;
use App\Domain\User\User;

class UserFactoryTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreate()
    {
        $userFactory = new UserFactory();
        $user = $userFactory->create([
            'id'    => 1,
            'first_name'      => 'Firstname',
            'last_name'  => 'Lastname',
            'email'      => 'email@email.com',
            'gender'      => 'Male',
            'ip_address'  => '192.168.1.1'
        ]);
        $this->assertInstanceOf('App\Domain\User\User',$user);
        $this->assertEquals('1', $user->getId());
    }
}
