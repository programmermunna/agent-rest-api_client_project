<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Models\BetModel;
use App\Models\BetsTogel;
use App\Models\BonusFreebetModel;
use App\Models\DepositModel;
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
                $bonus_freebet = BonusFreebetModel::first();
                $durasiBonus = $bonus_freebet->durasi_bonus_promo;
                $subDay = Carbon::now()->subDays($durasiBonus)->format('Y-m-d 00:00:00');
                $today = Carbon::now()->format('Y-m-d 23:59:59');
                $Check_deposit_claim_bonus_freebet = DepositModel::where('members_id', auth('api')->user()->id)
                    ->where('approval_status', 1)
                    ->where('is_bonus_freebet', 1)
                    ->where('status_bonus_freebet', 0)
                    ->whereBetween('approval_status_at', [$subDay, $today])->orderBy('approval_status_at', 'desc')->first();

                # check member if claim bonus freebet
                if ($bonus_freebet->status_bonus == 1 && $Check_deposit_claim_bonus_freebet) {
                    $TOSlotCasinoFish = BetModel::whereIn('type', ['Win', 'Lose', 'Bet', 'Settle'])
                        ->whereBetween('created_at', [$Check_deposit_claim_bonus_freebet->approval_status_at, now()])
                        ->where('created_by', auth('api')->user()->id)
                        ->where('game_info', 'slot')->sum('bet');

                    $TOTogel = BetsTogel::whereBetween('created_at', [$Check_deposit_claim_bonus_freebet->approval_status_at, now()])
                        ->where('created_by', auth('api')->user()->id)->sum('pay_amount');

                    $TOMember = $TOSlotCasinoFish + $TOTogel;

                    $total_depo = $Check_deposit_claim_bonus_freebet->jumlah;
                    $turnover_x = $bonus_freebet->turnover_x;
                    $bonus_amount = $bonus_freebet->bonus_amount;
                    $depoPlusBonus = $total_depo + (($total_depo * $bonus_amount) / 100);
                    $TO = $depoPlusBonus * $turnover_x;

                    if ($TOMember < $TO) {
                        return $this->errorResponse('Maaf, Bonus anda tidak memenuhi persyaratan, Turnover anda belum tercapai, Turnover anda saat ini sebesar Rp. ' . number_format($TOMember) . ', Turnover yang harus anda capai sebesar Rp. ' . number_format($TO), 400);
                    }

                    $payload = [
                        'members_id' => $memberId,
                        'rekening_id' => $bankAsalTransferForWd->id,
                        'rek_member_id' => $rekMember->id,
                        'jumlah' => $jumlah,
                        'note' => $request->note,
                        'is_claim_bonus_freebet' => 1,
                        'created_by' => $memberId,
                        'created_at' => Carbon::now(),
                    ];
                    $withdrawal = WithdrawModel::create($payload);

                    # update balance member
                    $member = MembersModel::find(auth('api')->user()->id);
                    MembersModel::where('id', auth('api')->user()->id)->update([
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

                } else {
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
                    MembersModel::where('id', auth('api')->user()->id)->update([
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

            }

            return $this->errorResponse('Bank Tujuan Untuk Withdraw Sedang Offline, Silahkan Hubungi Customer service', 400);
        } catch (\Throwable$th) {
            dd($th->getMessage());
            return $this->errorResponse('Internal Server Error', 500);
        }
    }
}
