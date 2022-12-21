<?php

namespace App\Listeners;

use App\Events\MemberUpdate;
use Spatie\WebhookServer\WebhookCall;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MemberUpdateListener
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
     * @param  \App\Events\MemberUpdate  $event
     * @return void
     */
    public function handle(MemberUpdate $event)
    {
        if ($event->getEmitAble()) {
            $member = $event->getMember();
            WebhookCall::create()
            ->url(env('WEBHOOK_URL').'/member-balance')
            ->payload(['member' => $member])
            ->useSecret('Cikatech')
            ->dispatchSync();
        }
    }
}
