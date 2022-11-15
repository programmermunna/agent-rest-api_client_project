<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

/**
 * this service class takes on synchronizing event among internal
 * individual services.
 *
 * might be scaled to cover some other areas in future
 */
class SyncApplicationEventsAmongServices
{
    public function notifyOverREST($url, $body = [], $header = [], $action = 'post'): array
    {
        /**
         * do data encryption to authenticate request just for security sake
         */
        $request = Http::withHeaders($header)->post($url, $body);

        return [
            'status' => $request->status(),
            'data' => $request->json(),
        ];
    }
}
