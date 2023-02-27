<?php

namespace App\Listeners;

use App\Events\BotDanaEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class BotDanaListener
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
     * @param  \App\Events\BotDanaEvent  $event
     * @return void
     */
    public function handle(BotDanaEvent $event)
    {
        //
    }
}
