<?php

namespace App\Services;


use App\Events\MaintenanceStatusUpdate;
use App\Events\MemberUpdate;
use App\Events\NotifyNewMemo;
use App\Models\MembersModel;
use App\Models\MemoModel;
use Illuminate\Http\Request;
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
        \Route::post('event-triggers', function (Request $request) {

            try {
                //@todo this whole dynamics can be scaled to suite generic purposes since we will likely
                //@todo to use single endpoint to handle multiple events

                 $events = [
                     NotifyNewMemo::class => [
                         'event' => NotifyNewMemo::class,
                         'model' => MemoModel::class,
                         'params' => [
                             'model_id' => 'memo_id',
                             'has_model' => 'has_model'
                         ]
                     ],
                     MemberUpdate::class => [
                         'event' => MemberUpdate::class,
                         'model' => MembersModel::class,
                         'params' => [
                             'model_id' => 'member_id',
                             'has_model' => 'has_model'
                         ]
                     ],
                     MaintenanceStatusUpdate::class => [
                         'event' => MaintenanceStatusUpdate::class,
                         'params' => [
                             'status' => 'status',
                             'has_model' => 'has_model'
                         ],
                     ]
                 ];

                 $event = $events[$request->event];
                 $eventHasModel = $request->{$event['params']['has_model']} ?? true;
                 $eventClass = $event['event'];

                 if ($eventHasModel && !in_array(MaintenanceStatusUpdate::class,$event)) {
                     $model = $event['model'];

                     $modelObject = $model::find($request->{$event['params']['model_id']});
                     $eventObject = new $eventClass($modelObject, false);
                 } else {
                     $eventObject = new $eventClass($request->{$event['params']['status']}, false);
                 }

                 event($eventObject);

                return response()->json([
                    'success' => true,
                ]);
            } catch (\Throwable $exception) {
                Log::error($exception);

                return response()->json([
                    'success' => false,
                ],500);
            }
        });
    }
}
