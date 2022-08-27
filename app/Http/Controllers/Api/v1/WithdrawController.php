<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Models\MembersModel;
use App\Models\RekeningModel;
use App\Models\RekMemberModel;
use App\Models\UserLogModel;
use App\Models\WithdrawModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithdrawController extends ApiController
{
    public function create(Request $request)
    {
        try {
            $cek_status_wd = WithdrawModel::where('members_id', auth('api')->user()->id)
                ->where('approval_status', 0)
                ->first();
            if ($cek_status_wd) {
                return $this->errorResponse("Maaf Anda masih ada transaksi withdraw yang belum selesai.", 400);
            }
            $memberId = auth('api')->user()->id; // atau bisa juga Auth::user()->id,
            $jumlah = str_replace(',', '', $request->jumlah);

            # filter dulu di sini
            # jumlah wd ngga boleh 0
            if (is_null($jumlah) || $jumlah == 0) {
                return $this->errorResponse("Jumlah harus diisi.", 400);
            }

            $memberWithdraw = $jumlah;
            $currCredit = MembersModel::find($memberId)->credit;

            $credit = $currCredit - $memberWithdraw;

            # ngga boleh withdraw kalau balance member ngga mencukupi.
            if ($credit < 0) { # 0 berarti si member bisa ambil semua creditnya.
                return $this->errorResponse("Credit/balance anda tidak mencukupi. Silakan ubah Jumlah maksimal " . number_format((float) $currCredit, 0) . " untuk melanjutkan withdraw.", 400);
            }
            # get member bank
            // $memberBankConsId = auth('api')->user()->constant_rekening_id;

            $bankAsalTransferForWd = RekeningModel::where('constant_rekening_id', $request->constant_rekening_id)
                ->where('is_wd', 1)
                ->first();
            $rekMember = RekMemberModel::where('rek_member.created_by', auth('api')->user()->id)
                ->select('id')
                ->where('is_wd', 1)
                ->first();
            if ($bankAsalTransferForWd) {
                $payload = [
                    'members_id' => $memberId,
                    'rekening_id' => $bankAsalTransferForWd->id,
                    'rek_member_id' => $rekMember->id,
                    'jumlah' => $jumlah,
                    'note' => $request->note,
                    'created_by' => $memberId,
                    'created_at' => Carbon::now(),
                ];
                $withdrawal = WithdrawModel::create($payload);

                # update balance member
                $member = MembersModel::find(auth('api')->user()->id);
                $member->update([
                    'credit' => $member->credit - $jumlah,
                ]);

                # activity Log
                $user = auth('api')->user();
                UserLogModel::logMemberActivity(
                    'Withdrawal Created',
                    $user,
                    $withdrawal,
                    [
                        'target' => 'Withdrawal',
                        'activity' => 'Create',
                        'ip_member' => auth('api')->user()->last_login_ip,
                    ],
                    "$user->username Created a Withdrawal with amount {$withdrawal->jumlah}"
                );
                auth('api')->user()->update([
                    'last_login_ip' => $request->ip,
                ]);

                return $this->successResponse(null, 'Berhasil request withdraw');
            }

            return $this->errorResponse('Bank Tujuan Untuk Withdraw Sedang Offline, Silahkan Hubungi Customer service', 400);
        } catch (\Throwable$th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }
}
