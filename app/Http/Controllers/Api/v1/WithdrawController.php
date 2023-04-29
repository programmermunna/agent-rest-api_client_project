<?php

namespace App\Http\Controllers\Api\v1;

use App\Events\CreateWithdrawalEvent;
use App\Events\WithdrawalCreateBalanceEvent;
use App\Http\Controllers\ApiController;
use App\Models\BetModel;
use App\Models\BetsTogel;
use App\Models\BonusSettingModel;
use App\Models\DepositModel;
use App\Models\DepositWithdrawHistory;
use App\Models\MembersModel;
use App\Models\RekeningModel;
use App\Models\RekMemberModel;
use App\Models\UserLogModel;
use App\Models\WithdrawModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WithdrawController extends ApiController
{
    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            $memberId = auth('api')->user()->id; // atau bisa juga Auth::user()->id,
            $cek_status_wd = WithdrawModel::where('members_id', $memberId)
                ->where('approval_status', 0)
                ->first();
            if ($cek_status_wd) {
                return $this->errorResponse("Maaf Anda masih ada transaksi withdraw yang belum selesai.", 400);
            }
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
            $rekMember = RekMemberModel::where('rek_member.created_by', $memberId)
                ->select('id')
                ->where('is_wd', 1)
                ->first();
            if ($bankAsalTransferForWd) {
                $bonus_freebet = BonusSettingModel::select(
                                    'status_bonus', 
                                    // 'durasi_bonus_promo', 
                                    'min_depo', 'max_depo', 
                                    'bonus_amount', 
                                    'turnover_x', 
                                    'constant_provider_id')
                                ->where('constant_bonus_id', 4)->first();
                # Check Bonus New Member
                if ($bonus_freebet->status_bonus == 1) {
                    // $durasiBonus = $bonus_freebet->durasi_bonus_promo - 1;
                    // $subDay = Carbon::now()->subDays($durasiBonus)->format('Y-m-d 00:00:00');
                    // $today = Carbon::now()->format('Y-m-d 23:59:59');
                    $Check_deposit_claim_bonus_freebet = DepositModel::where('members_id', $memberId)
                        ->where('approval_status', 1)
                        ->where('is_claim_bonus', 4)
                        ->where('status_bonus', 0)
                        // ->whereBetween('approval_status_at', [$subDay, $today])
                        ->orderBy('approval_status_at', 'desc')->first();
                    if ($Check_deposit_claim_bonus_freebet) {
                        $providerId = explode(',', $bonus_freebet->constant_provider_id);
                        if (!in_array(16, $providerId)) {
                            $TOSlotCasinoFish = BetModel::whereIn('type', ['Win', 'Lose', 'Bet', 'Settle'])
                                ->whereBetween('created_at', [$Check_deposit_claim_bonus_freebet->approval_status_at, now()])
                                ->where('created_by', $memberId)
                                ->whereIn('constant_provider_id', $providerId)->sum('bet');

                            $TOMember = $TOSlotCasinoFish;
                        } else {
                            $TOSlotCasinoFish = BetModel::whereIn('type', ['Win', 'Lose', 'Bet', 'Settle'])
                                ->whereBetween('created_at', [$Check_deposit_claim_bonus_freebet->approval_status_at, now()])
                                ->where('created_by', $memberId)
                                ->where('game_info', 'slot')->sum('bet');
                            $TOTogel = BetsTogel::whereBetween('created_at', [$Check_deposit_claim_bonus_freebet->approval_status_at, now()])
                                ->where('created_by', $memberId)->sum('pay_amount');

                            $TOMember = $TOSlotCasinoFish + $TOTogel;
                        }
                        
                        $total_depo = $Check_deposit_claim_bonus_freebet->jumlah;
                        $turnover_x = $bonus_freebet->turnover_x;
                        $bonus_amount = $bonus_freebet->bonus_amount;
                        $depoPlusBonus = $total_depo + (($total_depo * $bonus_amount) / 100);
                        $TO = $depoPlusBonus * $turnover_x;
                        
                        if ($TOMember < $TO) {
                            return $this->errorResponse('Maaf, Anda belum bisa melakukan withdraw saat ini, karena Anda belum memenuhi persyaratan untuk klaim Bonus New Member. Turnover Anda belum mencapai target saat ini, yaitu sebesar Rp. ' . number_format($TOMember) . '. Turnover yang harus anda capai adalah sebesar Rp. ' . number_format($TO), 400);
                        }
                        
                        $payload = [
                            'members_id' => $memberId,
                            'rekening_id' => $bankAsalTransferForWd->id,
                            'rek_member_id' => $rekMember->id,
                            'jumlah' => $jumlah,
                            'credit' => $credit,
                            'note' => $request->note,
                            'is_claim_bonus' => 4,
                            'created_by' => $memberId,
                            'created_at' => Carbon::now(),
                        ];
                        
                        $withdrawal = WithdrawModel::create($payload);
                        DB::commit();
                        return $this->successResponse($withdrawal, 'withdrawal');
                        # update balance member
                        $member = MembersModel::find($memberId);
                        MembersModel::where('id', $memberId)->update([
                            'credit' => $member->credit - $jumlah,
                        ]);
                        
                        // WEB SOCKET START
                        WithdrawalCreateBalanceEvent::dispatch(MembersModel::select('id', 'credit', 'username')->find($memberId)->toArray());
                        CreateWithdrawalEvent::dispatch($withdrawal->toArray());
                        // WEB SOCKET FINISH
                        
                        # activity Log
                        UserLogModel::logMemberActivity(
                            'Withdrawal Created',
                            $member,
                            $withdrawal,
                            [
                                'target' => 'Withdrawal',
                                'activity' => 'Create',
                                'ip_member' => $member->last_login_ip,
                            ],
                            "$member->username Created a Withdrawal with amount {$withdrawal->jumlah}"
                        );
                        DB::commit();
                        return $this->successResponse(null, 'Berhasil request withdraw');
                    }
                }

                $bonus_deposit = BonusSettingModel::select('status_bonus', 'durasi_bonus_promo', 'min_depo', 'max_depo', 'max_bonus', 'bonus_amount', 'turnover_x', 'constant_provider_id')->where('constant_bonus_id', 6)->first();
                # Check Bonus Existing Member
                if ($bonus_deposit->status_bonus == 1) {
                    $durasiBonus = $bonus_deposit->durasi_bonus_promo - 1;
                    $subDay = Carbon::now()->subDays($durasiBonus)->format('Y-m-d 00:00:00');
                    $today = Carbon::now()->format('Y-m-d 23:59:59');
                    $Check_deposit_claim_bonus_deposit = DepositModel::where('members_id', $memberId)
                        ->where('approval_status', 1)
                        ->where('is_claim_bonus', 6)
                        ->where('status_bonus', 0)
                        ->whereBetween('approval_status_at', [$subDay, $today])->orderBy('approval_status_at', 'desc')->first();
                    if ($Check_deposit_claim_bonus_deposit) {
                        $providerId = explode(',', $bonus_deposit->constant_provider_id);
                        if (!in_array(16, $providerId)) {
                            $TOSlotCasinoFish = BetModel::whereIn('type', ['Win', 'Lose', 'Bet', 'Settle'])
                                ->whereBetween('created_at', [$Check_deposit_claim_bonus_deposit->approval_status_at, now()])
                                ->where('created_by', $memberId)
                                ->whereIn('constant_provider_id', $providerId)->sum('bet');

                            $TOMember = $TOSlotCasinoFish;
                        } else {
                            $TOSlotCasinoFish = BetModel::whereIn('type', ['Win', 'Lose', 'Bet', 'Settle'])
                                ->whereBetween('created_at', [$Check_deposit_claim_bonus_deposit->approval_status_at, now()])
                                ->where('created_by', $memberId)
                                ->where('game_info', 'slot')->sum('bet');
                            $TOTogel = BetsTogel::whereBetween('created_at', [$Check_deposit_claim_bonus_deposit->approval_status_at, now()])
                                ->where('created_by', $memberId)->sum('pay_amount');

                            $TOMember = $TOSlotCasinoFish + $TOTogel;
                        }

                        $total_depo = $Check_deposit_claim_bonus_deposit->jumlah;
                        $turnover_x = $bonus_deposit->turnover_x;
                        $bonus_amount = $bonus_deposit->bonus_amount;
                        if ($total_depo > $bonus_deposit->max_bonus) {
                            $depoPlusBonus = $total_depo + $bonus_deposit->max_bonus;
                        } else {
                            $depoPlusBonus = $total_depo + (($total_depo * $bonus_amount) / 100);
                        }
                        $TO = $depoPlusBonus * $turnover_x;

                        if ($TOMember < $TO) {
                            return $this->errorResponse('Maaf, Anda belum bisa melakukan withdraw saat ini, karena Anda belum memenuhi persyaratan untuk klaim Bonus Existing Member. Turnover Anda belum mencapai target saat ini, yaitu sebesar Rp. ' . number_format($TOMember) . '. Turnover yang harus anda capai adalah sebesar Rp. ' . number_format($TO), 400);
                        }

                        $payload = [
                            'members_id' => $memberId,
                            'rekening_id' => $bankAsalTransferForWd->id,
                            'rek_member_id' => $rekMember->id,
                            'jumlah' => $jumlah,
                            'credit' => $credit,
                            'note' => $request->note,
                            'is_claim_bonus' => 6,
                            'created_by' => $memberId,
                            'created_at' => Carbon::now(),
                        ];
                        $withdrawal = WithdrawModel::create($payload);

                        # update balance member
                        $member = MembersModel::find($memberId);
                        MembersModel::where('id', $memberId)->update([
                            'credit' => $member->credit - $jumlah,
                        ]);

                        // WEB SOCKET START
                        WithdrawalCreateBalanceEvent::dispatch(MembersModel::select('id', 'credit', 'username')->find($memberId)->toArray());
                        // WEB SOCKET FINISH

                        # activity Log
                        UserLogModel::logMemberActivity(
                            'Withdrawal Created',
                            $member,
                            $withdrawal,
                            [
                                'target' => 'Withdrawal',
                                'activity' => 'Create',
                                'ip_member' => $member->last_login_ip,
                            ],
                            "$member->username Created a Withdrawal with amount {$withdrawal->jumlah}"
                        );
                        DB::commit();
                        return $this->successResponse(null, 'Berhasil request withdraw');
                    }
                }
                $payload = [
                    'members_id' => $memberId,
                    'rekening_id' => $bankAsalTransferForWd->id,
                    'rek_member_id' => $rekMember->id,
                    'jumlah' => $jumlah,
                    'credit' => $credit,
                    'note' => $request->note,
                    'created_by' => $memberId,
                    'created_at' => Carbon::now(),
                ];
                $withdrawal = WithdrawModel::create($payload);

                # Create History Withdraw
                DepositWithdrawHistory::create([
                    'withdraw_id' => $withdrawal->id,
                    'member_id' => $withdrawal->members_id,
                    'status' => 'Pending',
                    'amount' => $withdrawal->jumlah,
                    'credit' => $withdrawal->credit,
                    'description' => 'Withdraw : Pending',
                    'created_by' => $memberId,
                ]);

                # update balance member
                $member = MembersModel::find($memberId);
                MembersModel::where('id', $memberId)->update([
                    'credit' => $member->credit - $jumlah,
                ]);

                // WEB SOCKET START
                WithdrawalCreateBalanceEvent::dispatch(MembersModel::select('id', 'credit', 'username')->find($memberId)->toArray());
                // WEB SOCKET FINISH

                # activity Log
                UserLogModel::logMemberActivity(
                    'Withdrawal Created',
                    $member,
                    $withdrawal,
                    [
                        'target' => 'Withdrawal',
                        'activity' => 'Create',
                        'ip_member' => $member->last_login_ip,
                    ],
                    "$member->username Created a Withdrawal with amount {$withdrawal->jumlah}"
                );

                DB::commit();
                return $this->successResponse(null, 'Berhasil request withdraw');
            }

            return $this->errorResponse('Bank Tujuan Untuk Withdraw Sedang Offline, Silahkan Hubungi Customer service', 400);
        } catch (\Throwable$th) {
            DB::rollback();
            Log::error($th);
            return $this->errorResponse('Internal Server Error', 500);
        }
    }
}
