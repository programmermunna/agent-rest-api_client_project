<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
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

            return $this->successResponse(null, 'Tidak ada konten', 204);
        } catch (\Throwable$th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }

    public function imageContent($type)
    {
        try {

            if ($type == 'all') {
                $sildeAndPopupImages = ImageContent::select(
                    'type',
                    'path',
                    'alt',
                    'order',
                    'content',
                )
                    ->where('enabled', 1)->orderBy('type', 'asc')->orderBy('order', 'asc')->get();
                return $this->successResponse($sildeAndPopupImages, 'Datanya ada', 200);
            } else {
                $sildeAndPopupImages = ImageContent::select(
                    'type',
                    'path',
                    'alt',
                    'order',
                    'content',
                )
                    ->where('type', $type)->where('enabled', 1)->orderBy('order', 'asc')->get();
                if ($sildeAndPopupImages->count() <= 0) {
                    return $this->successResponse($sildeAndPopupImages, $type . ' aktif', 200);
                } else {
                    return $this->successResponse($sildeAndPopupImages, $type . ' nonaktif', 200);
                }
            }
        } catch (\Throwable$th) {
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

            return $this->successResponse(null, 'Tidak ada konten', 204);
        } catch (\Throwable$th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }

    public function bannerPromoBonus()
    {
        try {
            $bannerTurnover = ImageContent::select(
                'id',
                'path',
                'title',
                'content',
                'alt',
            )
                ->where('enabled', 1)
                ->where(function ($query) {
                    $query->where('type', 'turnover')
                        ->orWhere('type', 'bonus_new_member')
                        ->orWhere('type', 'bonus_next_deposit')
                        ->orWhere('type', 'cashback')
                        ->orWhere('type', 'rolling')
                        ->orWhere('type', 'bonus')
                        ->orWhere('type', 'referral')
                        ->orWhere('type', 'freebet');
                })
                ->orderByRaw('FIELD(type, "turnover", "bonus_new_member", "bonus_next_deposit", "cashback", "rolling", "referral", "bonus", "freebet")')
                ->get();
            if (is_null($bannerTurnover)) {
                return $this->successResponse(null, 'Iklan nonaktif', 200);
            } else {
                return $this->successResponse($bannerTurnover, 'Iklan aktif', 200);
            }
        } catch (\Throwable$th) {
            return $this->errorResponse($th->getMessage(), 500);
        }
    }

}
