<?php

namespace App\Listeners;

use App\Events\UserFoundEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\UserDataService;
use App\Domain\DataService\DataServiceMessage;
use Log;


class UserFoundListener
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
     * @param  UserFoundEvent  $event
     * @return void
     */
    public function handle(UserFoundEvent $event)
    {
      $msg = new DataServiceMessage('UserData',$event->user, $event->correlation_id);
      $this->dataService->publishToTopic($msg, 'RES.USER.UserResponses');
      $this->dataService->disconnect();
      Log::debug('User Found - returning response with correlation_id ' . $event->correlation_id);
    }
}
