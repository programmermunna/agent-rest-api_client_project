<?php

namespace App\Listeners;

use App\Events\NotifyNewMemo;
use App\Repositories\OrganizationServiceRepository;
use App\Services\SyncApplicationEventsAmongServices;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class DispatchNewMemoEventToExternalService
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
     * @param  object  $event
     * @return void
     */
    public function handle(NotifyNewMemo $event)
    {
        //@todo extract this and make this a queue able job so we can manage REST
        //@todo response state to determine if job is done else set retries.
        if ($event->emitAble()) {
            $memo = $event->getMemo();
            //sends api call with payload to intending listener
            $externalServices = (new OrganizationServiceRepository())->getAllItems();

            $externalServicesEventDispatcher = new SyncApplicationEventsAmongServices();
            foreach ($externalServices as $service) {
                $url = config('app.environment') === 'production' ?
                    "{$service->production_url}{$service->events_endpoint}" :
                    "{$service->staging_url}{$service->events_endpoint}";

                $externalServicesEventDispatcher->notifyOverREST(
                    $url,
                    [
                        'event' => NotifyNewMemo::class,
                        'memo_id' => $memo->id
                    ]
                );
            }
        }
    }
}
