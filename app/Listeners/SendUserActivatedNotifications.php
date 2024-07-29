<?php

namespace App\Listeners;

use App\Events\UserActivated;
use App\Notifications\ActivateUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendUserActivatedNotifications implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserActivated $event): void
    {
        $event->user->notify(new ActivateUser($event->user));
    }
}
