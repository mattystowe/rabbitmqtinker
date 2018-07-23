<?php

namespace App\Listeners;

use App\Events\UserNotFoundEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\UserDataService;
use App\Domain\DataService\DataServiceMessage;
use Log;

class UserNotFoundListener
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
     * @param  UserNotFoundEvent  $event
     * @return void
     */
    public function handle(UserNotFoundEvent $event)
    {
      $msg = new DataServiceMessage('UserNotFound','', $event->correlation_id);
      $this->dataService->publishToTopic($msg, 'RES.USER.UserResponses');
      $this->dataService->disconnect();
      Log::debug('User NOT Found - returning response with correlation_id ' . $event->correlation_id);
    }
}
