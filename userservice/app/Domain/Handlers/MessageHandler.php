<?php

namespace App\Domain\Handlers;

use App\Events\GetUserEvent;
use App\Events\InvalidRequestEvent;

class MessageHandler {

    public $body;
    public $correlation_id;

    public $handlers = [
      'GetUser'     =>    'GetUserEvent',
      'UpdateUser'  =>    'UpdateUserEvent',
      'DeleteUser'  =>    'DeleteUserEvent'
    ];

    public function __construct($body, $correlation_id)
    {
        $this->body = json_decode($body);
        $this->correlation_id = $correlation_id;
        $this->run();
    }


    public function run() {
        if ($this->requestIsValid($this->body->MESSAGE_TYPE)) {
          $event = 'App\Events\\' . $this->handlers[$this->body->MESSAGE_TYPE];
          event(new $event($this->body, $this->correlation_id));
        } else {
          event(new InvalidRequestEvent($this->correlation_id));
        }
    }

    public function requestIsValid($type) {
      if (array_key_exists($type, $this->handlers)) {
        return true;
      }
      return false;
    }


}
