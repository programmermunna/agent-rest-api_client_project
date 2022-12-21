<?php

namespace App\Listeners;

use App\Events\CreateDepositEvent;
use Spatie\WebhookServer\WebhookCall;
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
            WebhookCall::create()
            ->url(env('WEBHOOK_URL').'/create-deposit-event')
            ->payload(['deposit_id' => $deposit->id])
            ->useSecret('Cikatech')
            ->dispatchSync();
        }
    }
}
