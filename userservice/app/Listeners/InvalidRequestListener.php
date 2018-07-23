<?php

namespace App\Listeners;

use App\Events\InvalidRequestEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\UserDataService;
use App\Domain\DataService\DataServiceMessage;
use Log;

class InvalidRequestListener
{
  public $dataService;

  /**
   * Create the event listener.
   *
   * @return void
   */
  public function __construct(UserDataService $dataService)
  {
      $this->dataService = $dataService;
  }

    /**
     * Handle the event.
     *
     * @param  InvalidRequestEvent  $event
     * @return void
     */
    public function handle(InvalidRequestEvent $event)
    {
      $msg = new DataServiceMessage('InvalidRequest','', $event->correlation_id);
      $this->dataService->publishToTopic($msg, 'RES.USER.UserResponses');
      $this->dataService->disconnect();
      Log::debug('Invalid Request - returning response with correlation_id ' . $event->correlation_id);
    }
}
