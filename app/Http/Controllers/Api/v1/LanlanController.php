<?php

namespace App\Http\Controllers\Api\v1;

use App\Domains\Announcement\Services\AnnouncementService;
use App\Http\Controllers\ApiController;
use App\Models\AppSetting;
use Carbon\Carbon;
use App\Domains\Announcement\Models\Announcement;

class LanlanController extends ApiController
{
    protected $announcementService;

    public function __construct(AnnouncementService $announcementService)
    {
        $this->announcementService = $announcementService;
    }

    public function broadcast()
    {
        try {
            $broadcasts = $this->announcementService->getForFrontend();
            if ($broadcasts->count() >= 1) {
                return $this->successResponse($broadcasts->pluck('message'));
            }

            return $this->successResponse(null, 'No content', 204);
        } catch (\Throwable $th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }
    // public function broadcast()
    // {
    //     try {
    //         $broadcasts = Announcement::where('area', 'frontend')->get();
    //         if ($broadcasts) {
    //             return $this->successResponse($broadcasts->pluck('message'));
    //         }else{
    //             return $this->successResponse(null, 'No content', 204);
    //         }
    //     } catch (\Throwable $th) {
    //         return $this->errorResponse('Internal Server Error', 500);
    //     }
    // }

    public function apk()
    {
        try {
            $apk = AppSetting::where('name', 'apk_url')->value('value');
            if ($apk) {
                return $this->successResponse($apk);
            }

            return $this->successResponse(null, 'No content', 204);
        } catch (\Throwable $th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }

    public function livechat()
    {
        try {
            $livechat_tag = AppSetting::where('name', 'live_chat_tag')->value('value');
            $livechat_url = AppSetting::where('name', 'live_chat_url')->value('value');

            if ($livechat_tag || $livechat_url) {
                return $this->successResponse([
                    'tag' => $livechat_tag,
                    'url' => $livechat_url,
                ]);
            }

            return $this->successResponse(null, 'No content', 204);
        } catch (\Throwable $th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }

    public function whatsapp()
    {
        try {
            $whatsapp_number = AppSetting::where('name', 'whatsapp')->value('value');
            $whatsapp_url = AppSetting::where('name', 'whats_app_url')->value('value');

            if ($whatsapp_number || $whatsapp_url) {
                return $this->successResponse([
                    'number' => $whatsapp_number,
                    'url' => $whatsapp_url,
                ]);
            }

            return $this->successResponse(null, 'No content', 204);
        } catch (\Throwable $th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }

    public function multimedia()
    {
        try {
            $multiMedias = AppSetting::where('name', 'multimedia')->value('value');

            if ($multiMedias) {
                $medias = explode(',', $multiMedias);

                return $this->successResponse($medias);
            }

            return $this->successResponse(null, 'No content', 204);
        } catch (\Throwable $th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }

    public function maintenance(Type $var = null)
    {
        try {
            $maintenance = AppSetting::where('name', 'status')->where('type', 'maintenance')->value('value');

            if ($maintenance) {
                //if value on database 503 == maintenance, 
                if ($maintenance == 503) {
                    $response['code'] = 503;

                    $response['message'] = AppSetting::where('name', 'main_maintenance')->where('type', 'maintenance')->value('value');

                    $response['description'] = AppSetting::where('name', 'main_maintenance_description')->where('type', 'maintenance')->value('value');

                    //if value on database 200 == website is no maintenance
                    return $this->errorResponse('Maintenance Mode', 200, $response);
                }
            }
            return $this->successResponse(null, 'No content', 204);
        } catch (\Throwable $th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }


    public function maintenanceWebsite()
    {
        // try {
            $maintenance = AppSetting::where('name', 'status')->where('type', 'maintenance')->first();
            //if value on database 503 == maintenance, 
            if (request()->value == 200) {
                $response['code'] = 503;

                $response['message'] = AppSetting::where('name', 'main_maintenance')->where('type', 'maintenance')->value('value');

                $response['description'] = AppSetting::where('name', 'main_maintenance_description')->where('type', 'maintenance')->value('value');
                $maintenance->update(
                    [
                        'value' => 503,
                        'type' => 'maintenance',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]
                );
                //if value on database 200 == website is no maintenance
                return $this->errorResponse('Maintenance Mode', 200, $response);
            }elseif(request()->value == 503){
                $maintenance->update(
                    [
                        'value' => 200,
                        'type' => 'maintenance',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]
                );
                return $this->successResponse('No Maintenance', 200);
            }
        // } catch (\Throwable $th) {
        //     return $this->errorResponse('Internal Server Error', 500);
        // }
    }
}
