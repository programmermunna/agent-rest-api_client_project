<?php

namespace App\Listeners;

use App\Events\WithdrawalCreateBalanceEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class WithdrawalCreateBalanceEventListener
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
     * @param  \App\Events\WithdrawalCreateBalanceEvent  $event
     * @return void
     */
    public function handle(WithdrawalCreateBalanceEvent $event)
    {
        //
    }
}
