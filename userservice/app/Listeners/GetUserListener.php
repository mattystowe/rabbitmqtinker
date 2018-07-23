<?php

namespace App\Listeners;

use App\Events\GetUserEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;
use App\User;
use App\Events\UserNotFoundEvent;
use App\Events\UserFoundEvent;

class GetUserListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  GetUserEvent  $event
     * @return void
     */
    public function handle(GetUserEvent $event)
    {
        $user = User::find($event->body->payload);
        if ($user) {
          //found - fire user found event
          event(new UserFoundEvent($user, $event->correlation_id));
        } else {
          //not found - fire user not found event
          event(new UserNotFoundEvent($event->correlation_id));
        }

    }
}
