<?php

namespace App\Listeners;

use App\Events\BetTogelBalanceEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class BetTogelBalanceEventListener
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
     * @param  \App\Events\BetTogelBalanceEvent  $event
     * @return void
     */
    public function handle(BetTogelBalanceEvent $event)
    {
        //
    }
}
