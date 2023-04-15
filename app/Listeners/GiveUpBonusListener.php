<?php

namespace App\Listeners;

use App\Events\GiveUpBonusEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class GiveUpBonusListener
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
     * @param  \App\Events\GiveUpBonusEvent  $event
     * @return void
     */
    public function handle(GiveUpBonusEvent $event)
    {
        //
    }
}
