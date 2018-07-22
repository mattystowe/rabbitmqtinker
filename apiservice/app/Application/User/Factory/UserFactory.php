<?php

namespace App\Application\User\Factory;

use App\Domain\User\User;

class UserFactory {


  public function create(array $data): User
  {

    $user = new User();
    $user->setId($data['id'])
          ->setFirstName($data['first_name'])
          ->setLastName($data['last_name'])
          ->setEmail($data['email'])
          ->setGender($data['gender'])
          ->setIpAddress($data['ip_address']);
    return $user;

  }


}
