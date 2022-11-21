<?php

namespace App\Listeners;

use App\Events\MaintenanceStatusUpdate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class MaintenanceStatusUpdateListener
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
     * @param  \App\Events\MaintenanceStatusUpdate  $event
     * @return void
     */
    public function handle(MaintenanceStatusUpdate $event)
    {
        //
    }
}
