<?php

namespace App\Http\Controllers\Api\v1;

use Carbon\Carbon;
use App\Models\DepositModel;
use App\Models\MembersModel;
use App\Models\UserLogModel;
use Illuminate\Http\Request;
use App\Models\RekMemberModel;
use App\Models\ConstantProvider;
use App\Models\BonusFreebetModel;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Validator;

class DepositController extends ApiController
{
    public function create(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'rekening_id' => 'required|integer',
                    'jumlah' => 'required|integer',
                    'note' => 'sometimes|nullable',
                    'rekening_member_id' => 'required|integer',
                    'is_bonus_freebet' => 'sometimes',
                ]
            );
            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->first(), 422);
            }

            $cek_status_depo = DepositModel::where('members_id', auth('api')->user()->id)
                ->where('approval_status', 0)
                ->first();
            if ($cek_status_depo) {
                return $this->errorResponse("Maaf Anda masih ada transaksi Deposit yang belum selesai.", 400);
            }

            $check_bonus_freebet = BonusFreebetModel::select('min_depo', 'max_depo', 'status_bonus', 'durasi_bonus_promo')->first();
            $durasiBonus = $check_bonus_freebet->durasi_bonus_promo;
            $subDay = Carbon::now()->subDays($durasiBonus)->format('Y-m-d 00:00:00');
            $today = Carbon::now()->format('Y-m-d 23:59:59');
            $check_claim_bonus = DepositModel::where('members_id', auth('api')->user()->id)
                ->where('approval_status', 1)
                ->where('is_bonus_freebet', 1)
                ->whereBetween('approval_status_at', [$subDay, $today])->orderBy('approval_status_at', 'desc')->first();
            if ($request->is_bonus_freebet == 1 && $check_bonus_freebet->status_bonus == 1) {
                if ($check_claim_bonus) {
                    return $this->errorResponse("Maaf, Bonus Freebet dapat diklaim sehari sekali.", 400);
                }
                if ($request->jumlah < $check_bonus_freebet->min_depo) {
                    return $this->errorResponse("Maaf, Minimal deposit untuk klaim bonus freebet sebesar " . number_format($check_bonus_freebet->min_depo) . ".", 400);
                }
                if ($request->jumlah > $check_bonus_freebet->max_depo) {
                    return $this->errorResponse("Maaf, Maksimal deposit untuk klaim bonus freebet sebesar " . number_format($check_bonus_freebet->max_depo) . ".", 400);
                }
            };
            $active_rek = RekMemberModel::where([['created_by', auth('api')->user()->id], ['is_depo', 1]])->first();

            $payload = [
                'rek_member_id' => $request->rekening_member_id,
                'members_id' => auth('api')->user()->id,
                'rekening_id' => $request->rekening_id,
                'jumlah' => $request->jumlah,
                'is_bonus_freebet' => $request->is_bonus_freebet ?? 0,
                'note' => $request->note,
                'created_by' => auth('api')->user()->id,
                'created_at' => Carbon::now(),
            ];

            // $active_rek = RekMemberModel::where([['created_by', auth('api')->user()->id],['is_depo', 1]])->first();
            if ((!empty($active_rek)) && ($active_rek->is_depo == 1)) {
                if ($active_rek->id != $request->rekening_member_id) {
                    $active_rek->update([
                        'is_depo' => 0,
                    ]);
                }
                $new_active_rek = RekMemberModel::find($request->rekening_member_id);
                $new_active_rek->update([
                    'is_depo' => 1,
                ]);
            }

            $deposit = DepositModel::create($payload);

            // MembersModel::where('id', auth('api')->user()->id)
            //         ->update([
            //             'rekening_id_tujuan_depo' => $request->rekening_id,
            //         ]);

            $user = auth('api')->user();
            UserLogModel::logMemberActivity(
                'Deposit Created',
                $user,
                $deposit,
                [
                    'target' => 'Deposit',
                    'activity' => 'Create Deposit',
                    'ip_member' => auth('api')->user()->last_login_ip,
                ],
                $user->username . ' Created a Deposit with amount ' . number_format($deposit->jumlah)
            );
            // auth('api')->user()->update([
            //     'last_login_ip' => $request->ip,
            // ]);

            return $this->successResponse(null, 'Deposit berhasil');
        } catch (\Throwable$th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }

    public function dataBonusFreebet()
    {
        try {
            $userId = auth('api')->user()->id;
            $dataSetting = BonusFreebetModel::select(
                'id',
                'min_depo',
                'max_depo',
                'bonus_amount',
                'turnover_x',
                'turnover_amount',
                'info',
                'status_bonus',
                'durasi_bonus_promo',
                'provider_id',
            )->get();

            $dataBonusSetting = [];
            foreach ($dataSetting as $key => $item) {
                $provider_id = explode(',', $item->provider_id);
                $providers = [];
                foreach ($provider_id as $key => $value) {
                    if ($value != 16) {
                        $providers[] = ConstantProvider::select('id', 'constant_provider_name as name')->find($value);
                    } else {
                        $providers[] = ['id' => 16, 'name' => 'Game Togel'];
                    }
                }
                $durasiBonus = $item->durasi_bonus_promo;
                $subDay = Carbon::now()->subDays($durasiBonus)->format('Y-m-d 00:00:00');
                $today = Carbon::now()->format('Y-m-d 23:59:59');
                $checkKlaimBonus = DepositModel::select('bonus_freebet_amount', 'is_bonus_freebet', 'status_bonus_freebet')
                    ->where('is_bonus_freebet', 1)
                    ->where('status_bonus_freebet', 0)
                    ->where('approval_status', 1)
                    ->where('members_id', $userId)
                    ->whereBetween('approval_status_at', [$subDay, $today])->orderBy('approval_status_at', 'desc')->first();
                $dataBonusSetting[] = [
                    'id' => $item->id,
                    'name_bonus' => 'Bonus Freebet',
                    'min_depo' => (float) $item->min_depo,
                    'max_depo' => (float) $item->max_depo,
                    'bonus_amount' => (int) $item->bonus_amount,
                    'turnover_x' => $item->turnover_x,
                    'turnover_amount' => (float) $item->turnover_amount,
                    'info' => $item->info,
                    'status_bonus' => $item->status_bonus,
                    'durasi_bonus_promo' => $item->durasi_bonus_promo,
                    'is_bonus_freebet' => $checkKlaimBonus ? 1 : 0,
                    'provider_id' => $item->provider_id ? $providers : [],
                ];
            }
            return $this->successResponse($dataBonusSetting, 'Setting Bonus Freebet berhasil ditampilkan');
        } catch (\Throwable$th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }

    /**
     * @param $active_rek
     * @param Request $request
     * @param array $payload
     */
    public function extracted($active_rek, Request $request, array $payload): void
    {
        if ((!empty($active_rek)) && ($active_rek->is_depo == 1)) {
            if ($active_rek->id != $request->rekening_member_id) {
                $active_rek->update([
                    'is_depo' => 0,
                ]);
            } else {
                $new_active_rek = RekMemberModel::find($request->rekening_member_id);
                $new_active_rek->update([
                    'is_depo' => 1,
                ]);
            }
        }

        DepositModel::insert($payload);
    }
    public function BonusFreebetGivUp(Request $request)
    {
        try {
            $check_bonus_freebet = BonusFreebetModel::select('min_depo', 'max_depo', 'status_bonus', 'durasi_bonus_promo')->first();
            if($check_bonus_freebet->status_bonus == 1){
                $deposit = DepositModel::where('members_id', auth('api')->user()->id)
                ->where('is_bonus_freebet', 1)
                ->where('created_at',Carbon::now())->first();
                if($deposit != null && $deposit->is_bonus_freebet = 1){
                    $member = MembersModel::where('id', auth('api')->user()->id)->first();
                    $credit = $member->credit - $deposit->bonus_freebet_amount;
                    MembersModel::where('id', auth('api')->user()->id)
                    ->update([
                        'credit' => $credit,
                        'updated_by' => auth('api')->user()->id,
                        'updated_at' => Carbon::now()
                    ]);
                    UserLogModel::logMemberActivity(
                        'Bonus FreeBet Giveup',
                        $member,
                        $deposit,
                        [
                            'target' => 'Bonus FreeBet',
                            'activity' => 'Bonus FreeBet Giveup',
                            'ip_member' => auth('api')->user()->last_login_ip,
                        ],
                        $member->username . 'Deducted Bonus FreeBet amount from member balance  ' . number_format($deposit->bonus_freebet_amount)
                    );
                    auth('api')->user()->update([
                        'last_login_ip' => $request->ip,
                    ]);
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Bonus Freebet giveup successfully.'
                    ]);
                }
            }
            return $this->errorResponse("Maaf, Bonus Freebet sudah tidak aktif atau kadaluarsa.", 400);

        } catch (\Throwable$th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }
}
