<?php

namespace App\Http\Controllers\Api\v1;

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
use App\Models\TurnoverMember;
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
                if ($request->deposit_id == null) {
                    $bonus_new_member = BonusSettingModel::select('status_bonus')->where('constant_bonus_id', 4)->first();
                    if ($bonus_new_member->status_bonus == 1) {
                        $turnoverMember = TurnoverMember::select('deposit_id')->where('member_id', $memberId)->where('status', false)
                            ->whereRaw("IF(turnover_member >= turnover_target, true, false)")->pluck('deposit_id')->toArray();

                        if ($turnoverMember != []) {
                            $payload = [
                                'members_id' => $memberId,
                                'rekening_id' => $bankAsalTransferForWd->id,
                                'rek_member_id' => $rekMember->id,
                                'jumlah' => $jumlah,
                                'credit' => $credit,
                                'note' => $request->note,
                                'deposit_id' => ',' . implode(',', $turnoverMember) . ',',
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

                            # Update Withdraw di to table Turnover Members
                            TurnoverMember::whereIn('deposit_id', $turnoverMember)->update(['withdraw_id' => $withdrawal->id]);

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
                        } else {
                            $Check_deposit_claim_bonus_new_member = DepositModel::where('members_id', $memberId)
                                ->where('approval_status', 1)
                                ->where('is_claim_bonus', 4)
                                ->where('status_bonus', 0)
                                ->orderBy('approval_status_at', 'desc')->first();
                            if ($Check_deposit_claim_bonus_new_member) {
                                return $this->errorResponse('Maaf, Anda belum bisa melakukan withdraw saat ini, karena Anda belum memenuhi persyaratan untuk klaim Bonus New Member. Anda harus mencapai turnover untuk melakukan withdraw', 400);
                            }
                        }

                    }
                    $bonus_existing_member = BonusSettingModel::select('status_bonus', 'durasi_bonus_promo')->where('constant_bonus_id', 6)->first();
                    if ($bonus_existing_member->status_bonus == 1) {
                        $durasiBonus = $bonus_existing_member->durasi_bonus_promo - 1;
                        $subDay = Carbon::now()->subDays($durasiBonus)->format('Y-m-d 00:00:00');
                        $today = Carbon::now()->format('Y-m-d 23:59:59');
                        $Check_deposit_claim_bonus_existing_member = DepositModel::where('members_id', $memberId)
                            ->where('approval_status', 1)
                            ->where('is_claim_bonus', 6)
                            ->where('status_bonus', 0)
                            ->whereBetween('approval_status_at', [$subDay, $today])->orderBy('approval_status_at', 'desc')->first();
                        if ($Check_deposit_claim_bonus_existing_member) {
                            return $this->errorResponse('Maaf, Anda belum bisa melakukan withdraw saat ini, karena Anda belum memenuhi persyaratan untuk klaim Bonus Existing Member. Anda harus mencapai turnover untuk melakukan withdraw', 400);
                        }
                    }
                }

                if ($request->deposit_id != null) {
                    $payload = [
                        'members_id' => $memberId,
                        'rekening_id' => $bankAsalTransferForWd->id,
                        'rek_member_id' => $rekMember->id,
                        'jumlah' => $jumlah,
                        'credit' => $credit,
                        'note' => $request->note,
                        'deposit_id' => ',' . $request->deposit_id . ',',
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

                    # Update Withdraw di to table Turnover Members
                    TurnoverMember::whereIn('deposit_id', explode(',', $request->deposit_id))->update(['withdraw_id' => $withdrawal->id]);

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
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error($th);
            return $this->errorResponse('Internal Server Error', 500, $th->getMessage());
        }
    }

    public function listClaimBonus()
    {
        try {
            $memberId = auth('api')->user()->id;
            $bonus_existing = BonusSettingModel::leftJoin('constant_bonus', 'constant_bonus.id', 'bonus_setting.constant_bonus_id')
                ->select(
                    'bonus_setting.bonus_amount',
                    'bonus_setting.turnover_x',
                    'bonus_setting.status_bonus',
                    'bonus_setting.durasi_bonus_promo',
                    'bonus_setting.constant_provider_id',
                    'constant_bonus.nama_bonus',
                    'bonus_setting.constant_bonus_id'
                )->where('bonus_setting.constant_bonus_id', 6)->first();

            $bonus_new_member = BonusSettingModel::leftJoin('constant_bonus', 'constant_bonus.id', 'bonus_setting.constant_bonus_id')
                ->select(
                    'bonus_setting.bonus_amount',
                    'bonus_setting.turnover_x',
                    'bonus_setting.status_bonus',
                    'bonus_setting.constant_provider_id',
                    'constant_bonus.nama_bonus',
                    'bonus_setting.constant_bonus_id'
                )->where('bonus_setting.constant_bonus_id', 4)->first();

            $message1 = false;
            $message2 = false;
            $datas = [];

            $durasiBonus = $bonus_existing->durasi_bonus_promo - 1;
            $subDay = Carbon::now()->subDays($durasiBonus)->format('Y-m-d 00:00:00');
            $today = Carbon::now()->format('Y-m-d 23:59:59');

            # Check Claim Bonus Existing Member
            if ($bonus_existing->status_bonus == 1) {
                $checkBonusExisting = TurnoverMember::where('member_id', $memberId)->where('constant_bonus_id', 6)
                    ->whereNull('withdraw_id')->where('status', false)->get();
                if ($checkBonusExisting->toArray() == []) {
                    $checkBonusExisting = DepositModel::where('members_id', $memberId)
                        ->where('approval_status', 1)
                        ->where('is_claim_bonus', 6)
                        ->where('status_bonus', 0)
                        ->whereBetween('approval_status_at', [$subDay, $today])->orderBy('approval_status_at', 'desc')->get();

                    $checkTurnoverMember = TurnoverMember::where('member_id', $memberId)->where('constant_bonus_id', 6)
                        ->whereBetween('created_at', [$subDay, $today])
                        ->where('status', false)->first();
                    if (!$checkTurnoverMember) {
                        if ($checkBonusExisting->toArray() == []) {
                            $message1 = true;
                        } else {
                            $providerId = explode(',', $bonus_existing->constant_provider_id);
                            foreach ($checkBonusExisting as $key => $existingMemberBonus) {
                                if (!in_array(16, $providerId)) {
                                    $TOSlotCasinoFish = BetModel::whereIn('type', ['Win', 'Lose', 'Bet', 'Settle'])
                                        ->whereBetween('created_at', [$existingMemberBonus->approval_status_at, now()])
                                        ->where('created_by', $memberId)
                                        ->whereIn('constant_provider_id', $providerId)->sum('bet');

                                    $TOMember = $TOSlotCasinoFish;
                                } else {
                                    $TOSlotCasinoFish = BetModel::whereIn('type', ['Win', 'Lose', 'Bet', 'Settle'])
                                        ->whereBetween('created_at', [$existingMemberBonus->approval_status_at, now()])
                                        ->where('created_by', $memberId)
                                        ->whereIn('constant_provider_id', $providerId)->sum('bet');
                                    $TOTogel = BetsTogel::whereBetween('created_at', [$existingMemberBonus->approval_status_at, now()])
                                        ->where('created_by', $memberId)->sum('pay_amount');

                                    $TOMember = $TOSlotCasinoFish + $TOTogel;
                                }

                                $turnover_x = $bonus_existing->turnover_x;

                                $TO = ($existingMemberBonus->jumlah + $existingMemberBonus->bonus_amount) * $turnover_x;

                                if ($TOMember >= $TO) {
                                    $datas[] = [
                                        'bonus_name' => $bonus_existing->nama_bonus,
                                        'bonus_id' => $bonus_existing->constant_bonus_id,
                                        'date_claim' => $existingMemberBonus->approval_status_at,
                                        'turnover' => $TO,
                                        'turnover_member' => $TOMember,
                                        'deposit_id' => $existingMemberBonus->id,
                                        'deposit_amount' => $existingMemberBonus->jumlah,
                                        'bonus_amount' => $existingMemberBonus->bonus_amount,
                                    ];
                                }
                            }
                        }
                    } else {
                        $message1 = true;
                    }
                } else {
                    foreach ($checkBonusExisting as $key => $existingMemberBonus) {
                        $turnover_x = $bonus_existing->turnover_x;
                        $TOMember = $existingMemberBonus->turnover_member;
                        $TO = $existingMemberBonus->turnover_target;

                        if ($TOMember >= $TO) {
                            $datas[] = [
                                'bonus_name' => $bonus_existing->nama_bonus,
                                'bonus_id' => $bonus_existing->constant_bonus_id,
                                'date_claim' => $existingMemberBonus->approval_status_at,
                                'turnover' => $TO,
                                'turnover_member' => $TOMember,
                                'deposit_id' => $existingMemberBonus->deposit_id,
                                'deposit_amount' => $existingMemberBonus->jumlah,
                                'bonus_amount' => $existingMemberBonus->bonus_amount,
                            ];
                        }
                    }
                }
            } else {
                $message1 = true;
            }

            # Check Bonus New Member
            if ($bonus_new_member->status_bonus == 1) {
                $checkBonusNewMember = TurnoverMember::where('member_id', $memberId)->where('constant_bonus_id', 4)
                    ->whereNull('withdraw_id')
                    ->where('status', false)->first();

                if (!$checkBonusNewMember) {
                    $Check_deposit_claim_bonus_new_member = DepositModel::where('members_id', $memberId)
                        ->where('approval_status', 1)
                        ->where('is_claim_bonus', 4)
                        ->where('status_bonus', 0)
                        ->first();

                    $providerId = explode(',', $bonus_new_member->constant_provider_id);
                    if ($Check_deposit_claim_bonus_new_member) {
                        if (!in_array(16, $providerId)) {
                            $TOSlotCasinoFish = BetModel::whereIn('type', ['Win', 'Lose', 'Bet', 'Settle'])
                                ->whereBetween('created_at', [$Check_deposit_claim_bonus_new_member->approval_status_at, now()])
                                ->where('created_by', $memberId)
                                ->whereIn('constant_provider_id', $providerId)->sum('bet');

                            $TOMember = $TOSlotCasinoFish;
                        } else {
                            $TOSlotCasinoFish = BetModel::whereIn('type', ['Win', 'Lose', 'Bet', 'Settle'])
                                ->whereBetween('created_at', [$Check_deposit_claim_bonus_new_member->approval_status_at, now()])
                                ->where('created_by', $memberId)
                                ->whereIn('constant_provider_id', $providerId)->sum('bet');
                            $TOTogel = BetsTogel::whereBetween('created_at', [$Check_deposit_claim_bonus_new_member->approval_status_at, now()])
                                ->where('created_by', $memberId)->sum('pay_amount');

                            $TOMember = $TOSlotCasinoFish + $TOTogel;
                        }

                        $turnover_x = $bonus_new_member->turnover_x;

                        $TO = ($Check_deposit_claim_bonus_new_member->jumlah + $Check_deposit_claim_bonus_new_member->bonus_amount) * $turnover_x;

                        if ($TOMember >= $TO) {
                            $datas[] = [
                                'bonus_name' => $bonus_new_member->nama_bonus,
                                'bonus_id' => $bonus_new_member->constant_bonus_id,
                                'date_claim' => $Check_deposit_claim_bonus_new_member->approval_status_at,
                                'turnover' => $TO,
                                'turnover_member' => $TOMember,
                                'deposit_id' => $Check_deposit_claim_bonus_new_member->id,
                                'deposit_amount' => $Check_deposit_claim_bonus_new_member->jumlah,
                                'bonus_amount' => $Check_deposit_claim_bonus_new_member->bonus_amount,
                            ];
                        }
                    } else {
                        $message2 = true;
                    }
                } else {
                    $turnover_x = $bonus_new_member->turnover_x;
                    $TOMember = $checkBonusNewMember->turnover_member;
                    $TO = $checkBonusNewMember->turnover_target;

                    if ($TOMember >= $TO) {
                        $Check_deposit_claim_bonus_new_member = DepositModel::select('id', 'jumlah', 'bonus_amount', 'approval_status_at')->find($checkBonusNewMember->deposit_id);
                        $datas[] = [
                            'bonus_name' => $bonus_new_member->nama_bonus,
                            'bonus_id' => $bonus_new_member->constant_bonus_id,
                            'date_claim' => $Check_deposit_claim_bonus_new_member->approval_status_at,
                            'turnover' => $TO,
                            'turnover_member' => $TOMember,
                            'deposit_id' => $Check_deposit_claim_bonus_new_member->id,
                            'deposit_amount' => $Check_deposit_claim_bonus_new_member->jumlah,
                            'bonus_amount' => $Check_deposit_claim_bonus_new_member->bonus_amount,
                        ];
                    } else {
                        $message2 = true;
                    }
                }
            } else {
                $message2 = true;
            }

            if ($datas == []) {
                if ($message1 == true && $message2 == true) {
                    $message = 'Tidak klaim bonus';
                } else {
                    $message = 'Tidak Capai Turnover';
                }
            }

            return $this->successResponse($datas, $message ?? null, 200);

        } catch (\Throwable $th) {
            return $this->errorResponse('Internal Server Error', 500, $th->getMessage());
        }
    }
}
