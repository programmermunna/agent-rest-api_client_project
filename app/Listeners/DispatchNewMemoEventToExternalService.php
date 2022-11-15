<?php

namespace App\Listeners;

use App\Events\NotifyNewMemo;
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
        //sends api call with payload to intending listener
        Log::info('lister is effective');
    }
}
