<?php

namespace App\Services;

use App\Events\NotifyNewMemo;
use App\Models\MemoModel;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * this service class takes on synchronizing event among internal
 * individual services.
 *
 * might be scaled to cover some other areas in future
 */
class SyncApplicationEventsAmongServices
{
    /**
     * @param $url
     * @param $body
     * @param $header
     * @param $action
     * @return array
     */
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

    public static function routes()
    {
        \Route::post('event-triggers', function (\Request $request) {

            try {
                //@todo this whole dynamics can be scaled to suite generic purposes since we will likely
                //@todo to use single endpoint to handle multiple events
                $events = [
                    NotifyNewMemo::class => [
                        'event' => NotifyNewMemo::class,
                        'model' => MemoModel::class,
                    ],
                ];

                $model = $events[$request->event]['model'];
                $event = $events[$request->event]['event'];
                $params = $model::find($request->memo_id);
                $event = new $event($params, false);
                event($event);

                return response()->json([
                    'success' => true,
                ]);
            } catch (\Throwable $exception) {
                Log::error($exception);

                return response('', 500)->json([
                    'success' => false,
                ]);
            }
        });
    }
}
