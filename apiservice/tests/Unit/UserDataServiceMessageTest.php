<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Domain\DataService\UserDataServiceMessage;
use App\Domain\DataService\DataServiceMessage;

class UserDataServiceMessageTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetUser()
    {
        $msg = new UserDataServiceMessage('GetUser',1);

        $this->assertInstanceOf('App\Domain\DataService\DataServiceMessage',$msg);
        $payload = $msg->getPayload();

        $this->assertEquals(1, $msg->getPayload());
        $this->assertEquals('GetUser', $msg->getType());
        $this->assertTrue(array_key_exists('correlation_id',$msg->getParams()));
    }
}
