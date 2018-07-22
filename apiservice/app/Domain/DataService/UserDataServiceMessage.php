<?php

namespace App\Domain\DataService;

use App\Domain\DataService\DataServiceMessage;

class UserDataServiceMessage extends DataServiceMessage {

  public function __construct(?string $type, $payload)
  {
    parent::__construct($type, $payload);
  }
}
