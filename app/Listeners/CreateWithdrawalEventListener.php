<?php

namespace App\Listeners;

use App\Events\CreateDepositEvent;
use App\Events\CreateWithdrawalEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Repositories\OrganizationServiceRepository;
use App\Services\SyncApplicationEventsAmongServices;

class CreateWithdrawalEventListener
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
     * @param  \App\Events\CreateWithdrawalEvent  $event
     * @return void
     */
    public function handle(CreateWithdrawalEvent $event)
    {
        //
    }
}
