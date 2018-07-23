<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use App\Domain\Handlers\MessageHandler;

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

      $creds = [
        'host'      =>  env('RABBITMQ_HOST'),
        'port'      =>  env('RABBITMQ_PORT'),
        'user'      =>  env('RABBITMQ_USER'),
        'password'  =>  env('RABBITMQ_PASSWORD')
      ];
      $connection = new AMQPStreamConnection($creds['host'], $creds['port'], $creds['user'], $creds['password']);
      $channel = $connection->channel();
      $channel->exchange_declare('DataServiceExchange', 'topic', false, false, false);
      list($queue_name, ,) = $channel->queue_declare("", false, false, true, false);
      $channel->queue_bind($queue_name, 'DataServiceExchange', 'REQ.USER.UserRequests');

      echo " [*] Waiting for carrots. To exit press CTRL+C\n";

      $callback = function ($msg) use ($channel) {
          echo ' [x] :', $msg->body . ' - ' . $msg->get('correlation_id'), "\n";

          $handler = new MessageHandler($msg->body, $msg->get('correlation_id'));



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
