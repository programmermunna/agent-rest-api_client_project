<?php

namespace App\Listeners;

use App\Events\LastBetWinEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LastBetWinListener
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
     * @param  \App\Events\LastBetWinEvent  $event
     * @return void
     */
    public function handle(LastBetWinEvent $event)
    {
        //
    }
}
