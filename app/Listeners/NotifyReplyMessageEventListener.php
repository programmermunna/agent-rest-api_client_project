<?php

namespace App\Listeners;

use App\Events\NotifyReplyMessageEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyReplyMessageEventListener
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
     * @param  \App\Events\NotifyReplyMessageEvent  $event
     * @return void
     */
    public function handle(NotifyReplyMessageEvent $event)
    {
        //
    }
}
