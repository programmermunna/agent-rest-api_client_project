<?php

namespace App\Listeners;

use App\Events\NotifyReadMessageEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyReadMessageEventListener
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
     * @param  \App\Events\NotifyReadMessageEvent  $event
     * @return void
     */
    public function handle(NotifyReadMessageEvent $event)
    {
        //
    }
}
