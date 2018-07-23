<?php

namespace App\Services;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use App\Domain\DataService\DataServiceMessage;

class UserDataService {


  public $response = null;
  public $connection;
  public $channel;
  public $exchange = 'DataServiceExchange';

  public function __construct() {
    $this->connect([
      'host'      =>  env('RABBITMQ_HOST'),
      'port'      =>  env('RABBITMQ_PORT'),
      'user'      =>  env('RABBITMQ_USER'),
      'password'  =>  env('RABBITMQ_PASSWORD')
    ]);
  }


  public function connect($data)
  {
    $this->connection = new AMQPStreamConnection($data['host'], $data['port'], $data['user'], $data['password']);
    $this->channel = $this->connection->channel();
    $this->channel->exchange_declare($this->exchange, 'topic', false, false, false);
  }

  public function disconnect()
  {
    $this->channel->close();
    $this->connection->close();
  }


  public function publishToTopic(DataServiceMessage $msg, $topic) {
    $message = new AMQPMessage(json_encode($msg), $msg->getParams());
    $this->channel->basic_publish($message, $this->exchange, $topic);
  }


}
