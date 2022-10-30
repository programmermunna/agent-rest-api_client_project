<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Models\BonusFreebetModel;
use App\Models\DepositModel;
use App\Models\RekMemberModel;
use App\Models\UserLogModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

            $check_minimal_depo_bonus_freebet = BonusFreebetModel::select('min_depo')->first();
            $today = Carbon::now()->format('Y-m-d 00:00:00');
            $todayend = Carbon::now()->format('Y-m-d H:m:s');
            $check_claim_bonus = DepositModel::where('members_id', auth('api')->user()->id)
                ->where('approval_status', 1)
                ->where('is_bonus_freebet', 1)
                ->whereBetween('approval_status_at', [$today, $todayend])->first();
            if ($request->is_bonus_freebet == 1) {
                if ($check_claim_bonus) {
                    return $this->errorResponse("Maaf, Bonus Freebet dapat diklaim sehari sekali.", 400);
                }
                if ($request->jumlah < $check_minimal_depo_bonus_freebet->min_depo) {
                    return $this->errorResponse("Maaf, Minimal deposit untuk klaim bonus freebet minimal " . number_format($check_minimal_depo_bonus_freebet->min_depo) . ".", 400);
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
            $data = BonusFreebetModel::first();
            return $this->successResponse($data, 'Setting Bonus Freebet berhasil ditampilkan');
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
}
