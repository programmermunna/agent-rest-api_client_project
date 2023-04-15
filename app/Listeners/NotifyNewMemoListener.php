<?php

namespace App\Listeners;

use App\Events\NotifyNewMemoEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyNewMemoListener
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
     * @param  \App\Events\NotifyNewMemoEvent  $event
     * @return void
     */
    public function handle(NotifyNewMemoEvent $event)
    {
        //
    }
}
