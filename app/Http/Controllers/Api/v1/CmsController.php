<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Http\Resources\Api\v1\WebsiteContentResource;
use App\Models\BetModel;
use App\Models\BetsTogel;
use App\Models\BonusFreebetModel;
use App\Models\DepositModel;
use App\Models\ImageContent;
use App\Models\WebSiteContent;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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

    public function freebetBonus()
    {
        try {
            $bonus_freebet = BonusFreebetModel::first();
            $durasiBonus = $bonus_freebet->durasi_bonus_promo;
            $subDay = Carbon::now()->subDays($durasiBonus)->format('Y-m-d 00:00:00');
            $today = Carbon::now()->format('Y-m-d 23:59:59');
            $Check_deposit_claim_bonus_freebet = DepositModel::where('members_id', auth('api')->user()->id)
                ->where('approval_status', 1)
                ->where('is_bonus_freebet', 1)
                ->where('status_bonus_freebet', 0)
                ->whereBetween('approval_status_at', [$subDay, $today])->orderBy('approval_status_at', 'desc')->first();
            if ($bonus_freebet->status_bonus == 1 && $Check_deposit_claim_bonus_freebet) {
                $providerId = explode(',', $bonus_freebet->provider_id);
                if (!in_array(16, $providerId)) {
                    $TOSlotCasinoFish = BetModel::whereIn('type', ['Win', 'Lose', 'Bet', 'Settle'])
                        ->whereBetween('created_at', [$Check_deposit_claim_bonus_freebet->approval_status_at, now()])
                        ->where('created_by', auth('api')->user()->id)
                        ->whereIn('constant_provider_id', $providerId)->sum('bet');

                    $TOMember = $TOSlotCasinoFish;
                } else {
                    $TOSlotCasinoFish = BetModel::whereIn('type', ['Win', 'Lose', 'Bet', 'Settle'])
                        ->whereBetween('created_at', [$Check_deposit_claim_bonus_freebet->approval_status_at, now()])
                        ->where('created_by', auth('api')->user()->id)
                        ->where('game_info', 'slot')->sum('bet');
                    $TOTogel = BetsTogel::whereBetween('created_at', [$Check_deposit_claim_bonus_freebet->approval_status_at, now()])
                        ->where('created_by', auth('api')->user()->id)->sum('pay_amount');

                    $TOMember = $TOSlotCasinoFish + $TOTogel;
                }

                $total_depo = $Check_deposit_claim_bonus_freebet->jumlah;
                $turnover_x = $bonus_freebet->turnover_x;
                $bonus_amount = $bonus_freebet->bonus_amount;
                $depoPlusBonus = $total_depo + (($total_depo * $bonus_amount) / 100);
                $TO = $depoPlusBonus * $turnover_x;

                $data = [
                    'turnover' => $TO,
                    'turnover_member' => $TOMember,
                    'durasi_bonus_promo' => $bonus_freebet->durasi_bonus_promo,
                    'status_bonus' => $bonus_freebet->status_bonus,
                    'is_bonus_freebet' => $Check_deposit_claim_bonus_freebet->is_bonus_freebet,
                ];
            } else {
                $data = [
                    'turnover' => 0,
                    'turnover_member' => 0,
                    'durasi_bonus_promo' => 0,
                    'status_bonus' => 0,
                    'is_bonus_freebet' => 0,
                ];
            }
            return $this->successResponse($data, 'Datanya ada', 200);
        } catch (\Throwable$th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }
}
