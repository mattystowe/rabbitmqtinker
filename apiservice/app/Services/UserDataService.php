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

  public function consumeTopicWithCorrelationId($topic, $correlation_id) {
    list($queue_name, ,) = $this->channel->queue_declare("", false, false, true, false);
    $this->channel->queue_bind($queue_name, $this->exchange, $topic);
    $callback = function ($msg) use ($correlation_id) {
        if ($correlation_id == $msg->get('correlation_id')) {
          $this->response = $msg;
        }
    };
    $this->channel->basic_consume($queue_name, '', false, false, false, false, $callback);
  }

  public function waitForResponse() {
    while(is_null($this->response)) {
      $this->channel->wait();
    }
    $msg = json_decode($this->response->body);
    return [
      'MESSAGE_TYPE' => $msg->MESSAGE_TYPE,
      'payload' => $msg->payload
    ];
  }


}
