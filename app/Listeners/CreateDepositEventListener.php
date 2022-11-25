<?php

namespace App\Listeners;

use App\Events\CreateDepositEvent;
use App\Repositories\OrganizationServiceRepository;
use App\Services\SyncApplicationEventsAmongServices;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
        if ($event->getEmitAble()) {
            $deposit = $event->getDeposit();
            //sends api call with payload to intending listener
            $externalServices = (new OrganizationServiceRepository())->getAllItems();

            $externalServicesEventDispatcher = new SyncApplicationEventsAmongServices();
            foreach ($externalServices as $service) {
                $url = config('app.env') === 'production' ?
                    "{$service->production_url}{$service->events_endpoint}" :
                    "{$service->staging_url}{$service->events_endpoint}";

                $externalServicesEventDispatcher->notifyOverREST(
                    $url,
                    [
                        'event' => CreateDepositEvent::class,
                        'deposit_id' => $deposit->id,
                        'has_model' => true
                    ]
                );
            }
        }
    }
}
