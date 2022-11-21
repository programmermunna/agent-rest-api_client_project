<?php

namespace App\Listeners;

use App\Events\CreateDepositEvent;
use App\Events\CreateWithdrawalEvent;
use App\Repositories\OrganizationServiceRepository;
use App\Services\SyncApplicationEventsAmongServices;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
        if ($event->getEmitAble()) {
            $withdrawal = $event->getWithdrawModel();
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
                        'event' => CreateWithdrawalEvent::class,
                        'withdrawal_id' => $withdrawal->id,
                        'has_model' => true
                    ]
                );
            }
        }
    }
}
