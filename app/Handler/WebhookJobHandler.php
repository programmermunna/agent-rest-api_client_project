<?php

namespace App\Handler;

use Illuminate\Support\Facades\Log;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob;

class WebhookJobHandler extends ProcessWebhookJob
{
    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 120;

    public function handle()
    {
        //You can perform an heavy logic here

        Log::info($this->webhookCall->payload);
        sleep(10);
        Log::info("Webhook message done");
    }
}
