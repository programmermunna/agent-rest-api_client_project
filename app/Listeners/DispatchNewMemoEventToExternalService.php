<?php

namespace App\Listeners;

use App\Events\NotifyNewMemo;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Repositories\OrganizationServiceRepository;
use App\Services\SyncApplicationEventsAmongServices;

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
                $url = config('app.env') === 'production' ?
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
            // WebhookCall::create()
            // ->url(env('WEBHOOK_URL').'/new-memo-event')
            // ->payload(['memo_id' => $memo->id])
            // ->useSecret('Cikatech')
            // ->dispatchSync();
        }
    }
}
