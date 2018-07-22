<?php

namespace App\Domain\Dataservice;

use JsonSerializable;

class DataServiceMessage implements JsonSerializable {

  private $type;
  private $payload;
  private $params = [
    'correlation_id' => ''
  ];




  public function __construct(?string $type, $payload)
  {
    $this->setType($type)
      ->setPayload($payload)
      ->setCorrelationId(uniqid());

  }


  public function setPayload($payload): DataServiceMessage
  {
    $this->payload = $payload;
    return $this;
  }

  public function getPayload()
  {
    return $this->payload;
  }

  public function getPayloadAsJson(): string
  {
    return json_encode($this->getPayload());
  }

  public function setType(string $type): DataServiceMessage
  {
    $this->type = $type;
    return $this;
  }

  public function getType(): string
  {
    return $this->type;
  }

  public function setCorrelationId(?string $correlation_id): DataServiceMessage
  {
    $this->params['correlation_id'] = $correlation_id;
    return $this;
  }

  public function getCorrelationId(): string
  {
    return $this->params['correlation_id'];
  }

  public function getParams()
  {
    return $this->params;
  }


  public function jsonSerialize() {
    return [
      'MESSAGE_TYPE'  =>    $this->getType(),
      'payload'       =>    $this->getPayloadAsJson()
    ];
  }



}
