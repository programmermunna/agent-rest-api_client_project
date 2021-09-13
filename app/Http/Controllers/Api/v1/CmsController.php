<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Http\Resources\Api\v1\ImageContentResource;
use App\Http\Resources\Api\v1\WebsiteContentResource;
use App\Models\ImageContent;
use App\Models\WebSiteContent;

class CmsController extends ApiController
{
    public function websiteContent($slug)
    {
        try {
            $websiteContent = WebSiteContent::where('slug', $slug)->where('type', 'website')->first();
            if ($websiteContent) {
                return $this->successResponse(new WebsiteContentResource($websiteContent));
            }

            return $this->successResponse(null, 'No content', 204);
        } catch (\Throwable $th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }

    public function imageContent($type)
    {
        try {
            if ($type == 'all') {
                $sildeAndPopupImages = ImageContent::where('enabled', 1)->orderBy('type', 'asc')->orderBy('order', 'asc')->get();
            } else {
                $sildeAndPopupImages = ImageContent::where('type', $type)->where('enabled', 1)->orderBy('order', 'asc')->get();
            }

            return $this->successResponse(ImageContentResource::collection($sildeAndPopupImages));
        } catch (\Throwable $th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }

    
    // ($slug) => general-info , my-account , deposit , withdraw , about , help , rules , bank-information , contact-us , terms-and-conditions
    public function gameContent($slug)
    {
        try {
            $websiteContent = WebSiteContent::where('slug', $slug)->where('type', 'game')->first();
            if ($websiteContent) {
                return $this->successResponse(new WebsiteContentResource($websiteContent));
            }

            return $this->successResponse(null, 'No content', 204);
        } catch (\Throwable $th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }


    public function bannerPromoBonus()
    {
        try {
            $bannerTurnover =  ImageContent::select([
                    'id',
                    'path',
                    'title',
                    'content',
                    'alt',
                ])
                ->where('type', 'turnover')->orWhere('type', 'bonus_new_member')->orWhere('type', 'bonus_next_deposit')->orWhere('type', 'cashback')->where('enabled', 1)->get();
            if(is_null($bannerTurnover)){
                return $this->successResponse(null, 'No banner turnover', 200);
            }else{
                return $this->successResponse($bannerTurnover, 'Banner turnover', 200);
            }
        } catch (\Throwable $th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }

}
