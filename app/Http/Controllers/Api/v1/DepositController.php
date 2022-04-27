<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Models\DepositModel;
use App\Models\MembersModel;
use App\Models\WithdrawModel;
use App\Models\RekMemberModel;
use App\Models\UserLogModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

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
                ]
            );
            if($validator->fails()){
                return $this->errorResponse($validator->errors()->first(), 422);
            }
            $cek_status_wd  = WithdrawModel::where('members_id', auth('api')->user()->id)
                ->where('approval_status',0)
                ->first();
            $cek_status_depo = DepositModel::where('members_id', auth('api')->user()->id)
                ->where('approval_status',0)
                ->first();
            if ($cek_status_depo || $cek_status_wd){
                return $this->errorResponse("Maaf Anda masih ada transaksi yang belum selesai.", 400);
            }
            $active_rek = RekMemberModel::where([['created_by', auth('api')->user()->id],['is_depo', 1]])->first();

            $payload = [
                    'rek_member_id' => $request->rekening_member_id,
                    'members_id' => auth('api')->user()->id,
                    'rekening_id' => $request->rekening_id,
                    'jumlah' => $request->jumlah,
                    'note' => $request->note,
                    'created_by' => auth('api')->user()->id,
                    'created_at' => Carbon::now(),
                ];

            // $active_rek = RekMemberModel::where([['created_by', auth('api')->user()->id],['is_depo', 1]])->first();
            if ((! empty($active_rek)) && ($active_rek->is_depo == 1)) {
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
                    'activity' => 'Create',
                ],
                "$user->username Created a Deposit with amount {$deposit->jumlah}"
            );
            auth('api')->user()->update([
                'last_login_ip' => $request->ip,
            ]);

            return $this->successResponse(null, 'Deposit berhasil');
        } catch (\Throwable $th) {
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
        if ((! empty($active_rek)) && ($active_rek->is_depo == 1)) {
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
