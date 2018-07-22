<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;


class RabbitMQListen extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbitmq:listen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the rabbitMQ service to listen for request messages.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      $connection = new AMQPStreamConnection('localhost', '8053', 'admin', 'mypass');
      $channel = $connection->channel();
      $channel->exchange_declare('DataServiceExchange', 'topic', false, false, false);
      //die(print_r($channel->queue_declare("", false, false, true, false),true));
      list($queue_name, ,) = $channel->queue_declare("", false, false, true, false);
      $channel->queue_bind($queue_name, 'DataServiceExchange', 'REQ.*.*');
      //$channel->queue_bind($queue_name, 'DataService', 'UserRequests');


      echo " [*] Waiting for carrots. To exit press CTRL+C\n";

      $callback = function ($msg) use ($channel) {
          echo ' [x] :', $msg->body . ' - ' . $msg->get('correlation_id'), "\n";
          //
          //
          //publish back to the queue
          $response = [
            'MESSAGE_TYPE' => 'UserData',
            'payload' => [
              'id' => 1,
              'first_name' => 'matt',
              'last_name' => 'stowe',
              'email' => 'mmm@mmm.com',
              'gender' => 'male',
              'ip_address' => '123.455.23.45'
            ]
          ];
          $params = [
            'correlation_id' => $msg->get('correlation_id')
          ];

          $message = new AMQPMessage(json_encode($response), $params);
          $channel->basic_publish($message, 'DataServiceExchange', 'RES.USER.UserResponses');
      };

      $channel->basic_consume($queue_name, '', false, true, false, false, $callback);

      while (count($channel->callbacks)) {
          $channel->wait();
      }


      $channel->close();
      $connection->close();
    }
}
