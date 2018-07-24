<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Application\User\Service\UserApplicationService;
use App\Http\Controllers\UserController;
use App\Domain\User\User;
use Illuminate\Http\Response;

class UserControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetUser()
    {
        $mockUserApplicationService = $this->createMock(UserApplicationService::class);
        $mockUser = new User([
            'id'    => 1,
            'first_name'      => 'Firstname',
            'last_name'  => 'Lastname',
            'email'      => 'email@email.com',
            'gender'      => 'Male',
            'ip_address'  => '192.168.1.1'
        ]);
        $mockUserApplicationService->method('find')
            ->willReturn($mockUser);

        $userController = new UserController($mockUserApplicationService);

        $result = $userController->getUser(1);
        $this->assertInstanceOf(User::class, $result);
    }

    public function test200()
    {
        $response = $this->get('/getUser/1');

        $response->assertStatus(200);
    }

    public function test404Root()
    {
        $response = $this->get('/');

        $response->assertStatus(404);
    }

    public function test404UserNotFound()
    {
        $response = $this->get('/getUser/10000');

        $response->assertStatus(404);
    }

    public function test404InvalidRequest()
    {
        $response = $this->get('/getUser/invalid');

        $response->assertStatus(500);
    }

    public function test404NoIdInRequest()
    {
        $response = $this->get('/getUser');

        $response->assertStatus(404);
    }
}
