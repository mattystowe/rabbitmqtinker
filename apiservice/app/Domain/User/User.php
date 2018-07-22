<?php

namespace App\Domain\User;

use JsonSerializable;

class User implements JsonSerializable {


  private $id;
  private $first_name;
  private $last_name;
  private $email;
  private $gender;
  private $ip_address;

  /**
   * @param bool $id
   * @return User
   */
  public function setId(?int $id): User
  {
    $this->id = $id;
    return $this;
  }

  /**
   * @return bool id
   */
  public function getId(): int
  {
    return $this->id;
  }


  /**
   * @param string $firstname
   * @return User
   */
  public function setFirstName(?string $firstname): User
  {
    $this->first_name = $firstname;
    return $this;
  }

  /**
   * @return string first_name
   */
  public function getFirstName(): string
  {
    return $this->first_name;
  }


  /**
   * @param string $lastname
   * @return User
   */
  public function setLastName(?string $lastname): User
  {
    $this->last_name = $lastname;
    return $this;
  }

  /**
   * @return string last_name
   */
  public function getLastName(): string
  {
    return $this->last_name;
  }

  /**
   * @param string $email
   * @return User
   */
  public function setEmail(?string $email): User
  {
    $this->email = $email;
    return $this;
  }

  /**
   * @return string email
   */
  public function getEmail(): string
  {
    return $this->email;
  }

  /**
   * @param  ?string $gender
   * @return User
   */
  public function setGender(?string $gender): User
  {
    $this->gender = $gender;
    return $this;
  }

  /**
   * @return string gender
   */
  public function getGender(): string
  {
    return $this->gender;
  }

  /**
   * @param  ?string $ip
   * @return User
   */
  public function setIpAddress(?string $ip): User
  {
    $this->ip_address = $ip;
    return $this;
  }

  /**
   * @return string ip_address
   */
  public function getIpAddress(): string
  {
    return $this->ip_address;
  }

  /**
   * jsonSerialize the model for output as jsob
   * @return [type] [description]
   */
  public function jsonSerialize() {
    return [
      'id'            =>    $this->getId(),
      'first_name'    =>    $this->getFirstName(),
      'last_name'     =>    $this->getLastName(),
      'email'         =>    $this->getEmail(),
      'gender'        =>    $this->getGender(),
      'ip_address'    =>    $this->getIpAddress()
    ];
  }



}
