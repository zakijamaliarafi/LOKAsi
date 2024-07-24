<?php

namespace App\Listeners;

use App\Events\UserSuspended;
use App\Notifications\SuspendUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendUserSuspendedNotifications implements ShouldQueue
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
    public function handle(UserSuspended $event): void
    {
        $event->user->notify(new SuspendUser($event->user));
    }
}
