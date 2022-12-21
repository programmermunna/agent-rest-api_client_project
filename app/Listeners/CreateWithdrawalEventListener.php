<?php

namespace App\Listeners;

use App\Events\CreateDepositEvent;
use App\Events\CreateWithdrawalEvent;
use Spatie\WebhookServer\WebhookCall;
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
        if ($event->getEmitAble()) {
            $withdrawal = $event->getWithdrawModel();
            //sends api call with payload to intending listener
            // $externalServices = (new OrganizationServiceRepository())->getAllItems();

            // $externalServicesEventDispatcher = new SyncApplicationEventsAmongServices();
            // foreach ($externalServices as $service) {
            //     $url = config('app.env') === 'production' ?
            //         "{$service->production_url}{$service->events_endpoint}" :
            //         "{$service->staging_url}{$service->events_endpoint}";

            //     $externalServicesEventDispatcher->notifyOverREST(
            //         $url,
            //         [
            //             'event' => CreateWithdrawalEvent::class,
            //             'withdrawal_id' => $withdrawal->id,
            //             'has_model' => true
            //         ]
            //     );
            // }
            WebhookCall::create()
            ->url(env('WEBHOOK_URL').'/create-withdraw-event')
            ->payload(['withdrawal_id' => $withdrawal->id])
            ->useSecret('Cikatech')
            ->dispatchSync();
        }
    }
}
