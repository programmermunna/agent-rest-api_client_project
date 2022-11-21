<?php

namespace App\Listeners;

use App\Events\MemberUpdate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
        //
    }
}
