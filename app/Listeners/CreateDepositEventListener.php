<?php

namespace App\Listeners;

use App\Events\CreateDepositEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Repositories\OrganizationServiceRepository;
use App\Services\SyncApplicationEventsAmongServices;

class CreateDepositEventListener
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
     * @param  \App\Events\CreateDepositEvent  $event
     * @return void
     */
    public function handle(CreateDepositEvent $event)
    {
        //
    }
}
