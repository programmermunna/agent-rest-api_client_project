<?php

namespace App\Http\Controllers\Api\v1;

use App\Events\CreateDepositEvent;
use App\Events\GiveUpBonusEvent;
use App\Events\NotifyNewMemoEvent;
use App\Http\Controllers\ApiController;
use App\Models\BetModel;
use App\Models\BetsTogel;
use App\Models\BonusHistoryModel;
use App\Models\BonusHistoryReport;
use App\Models\BonusSettingModel;
use App\Models\ConstantBonusModel;
use App\Models\ConstantProvider;
use App\Models\DepositModel;
use App\Models\DepositWithdrawHistory;
use App\Models\MembersModel;
use App\Models\MemoModel;
use App\Models\RekeningModel;
use App\Models\RekMemberModel;
use App\Models\TurnoverMember;
use App\Models\UserLogModel;
use App\Models\WithdrawModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DepositController extends ApiController
{
    public $memberActive, $status;

    public function __construct()
    {
        try {
            $this->memberActive = auth('api')->user();
            $this->status = auth('api')->user()->status;
        } catch (\Throwable $th) {
            return $this->errorResponse('Token is Invalid or Expired', 401);
        }
    }

    public function create(Request $request)
    {
        if ($this->status != 1) {
            return $this->errorResponse("Maaf, Akun anda telah di tangguhkan, Anda tidak dapat melakukan transaksi deposit.", 400);
        }
        DB::beginTransaction();
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'rekening_id' => 'required|integer',
                    'jumlah' => 'required|integer',
                    'note' => 'sometimes|nullable',
                    'rekening_member_id' => 'required|integer',
                    'is_claim_bonus' => 'sometimes',
                ]
            );
            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->first(), 422);
            }
            if ($request->is_claim_bonus == 4 || $request->is_claim_bonus == 6) {
                if (!in_array($request->is_claim_bonus, [4, 6])) {
                    return $this->errorResponse("Maaf, Bonus tidak ditemukan.", 400);
                }
            }

            $cek_status_depo = DepositModel::where('members_id', $this->memberActive->id)
                ->where('approval_status', 0)
                ->first();
            if ($cek_status_depo) {
                return $this->errorResponse("Maaf Anda masih ada transaksi Deposit yang belum selesai.", 400);
            }

            $member = MembersModel::select(['id', 'credit'])->where('id', $this->memberActive->id)->first();

            # Check Bonus Existing
            $turnoverMember = TurnoverMember::where('member_id', $this->memberActive->id)
                ->where('constant_bonus_id', 6)->where('status', false)
                ->orderBy('id', 'desc')->first();
            if ($turnoverMember) {
                # Finish Bonus If Balance Member <= 200 and TO is not reached
                if ((($turnoverMember->turnover_member < $turnoverMember->turnover_target) && ($member->credit <= 200)) || ($turnoverMember->turnover_member >= $turnoverMember->turnover_target)) {
                    $turnoverMember->update([
                        'status' => true,
                    ]);
                }
            }

            # Check Bonus New Member
            if ($request->is_claim_bonus == 4) {
                $bonus_freebet = BonusSettingModel::select('status_bonus', 'durasi_bonus_promo', 'min_depo', 'max_depo', 'bonus_amount', 'max_bonus')
                    ->where('constant_bonus_id', $request->is_claim_bonus)->first();

                # Check Constant Bank
                $constantBank = RekeningModel::leftJoin('constant_rekening', 'constant_rekening.id', 'rekening.constant_rekening_id')
                    ->select(['rekening.id', 'rekening.constant_rekening_id'])->where('constant_rekening.is_bank', true)->find($request->rekening_id);
                if (!$constantBank) {
                    return $this->errorResponse("Maaf, Bonus New Member tidak dapat diklaim via deposit pulsa.", 400);
                }

                $check_claim_bonus = DepositModel::where('members_id', $this->memberActive->id)
                    ->where('approval_status', 1)->first();

                if ($bonus_freebet->status_bonus == 1) {
                    if ($check_claim_bonus) {
                        return $this->errorResponse("Maaf, Bonus New Member tidak dapat diklaim, Bonus New Member hanya dapat diklaim sekali.", 400);
                    }
                    if ($request->jumlah < $bonus_freebet->min_depo) {
                        return $this->errorResponse("Maaf, Minimal deposit untuk klaim bonus new member sebesar " . number_format($bonus_freebet->min_depo) . ".", 400);
                    }
                    if ($request->jumlah > $bonus_freebet->max_depo) {
                        return $this->errorResponse("Maaf, Maksimal deposit untuk klaim bonus new member sebesar " . number_format($bonus_freebet->max_depo) . ".", 400);
                    }
                } else {
                    return $this->errorResponse("Bonus New Member sedang tidak aktif.", 400);
                }
                $bonus = ($request->jumlah * $bonus_freebet->bonus_amount) / 100;
                $bonus = $bonus > $bonus_freebet->max_bonus ? $bonus_freebet->max_bonus : $bonus;
                $bonus_amount = $bonus_freebet->status_bonus == 1 ? $bonus : 0;
                $claimBonus = $bonus_freebet->status_bonus == 1 ? $request->is_claim_bonus : 0;
            }

            # Check Bonus Existing Member
            if ($request->is_claim_bonus == 6) {
                $bonus_deposit = BonusSettingModel::select('status_bonus', 'durasi_bonus_promo', 'limit_claim', 'min_depo', 'max_depo', 'bonus_amount', 'max_bonus')
                    ->where('constant_bonus_id', $request->is_claim_bonus)->first();

                # Check Constant Bank
                $constantBank = RekeningModel::leftJoin('constant_rekening', 'constant_rekening.id', 'rekening.constant_rekening_id')
                    ->select(['rekening.id', 'rekening.constant_rekening_id'])->where('constant_rekening.is_bank', true)->find($request->rekening_id);
                if (!$constantBank) {
                    return $this->errorResponse("Maaf, Bonus Existing Member tidak dapat diklaim via deposit pulsa.", 400);
                }
                # Check Bonus Existing Active or Not
                if ($bonus_deposit->status_bonus == 1) {
                    $today = Carbon::now()->format('Y-m-d');
                    $check_claim_bonus = DepositModel::where('members_id', $this->memberActive->id)
                        ->where('approval_status', 1)
                        ->where('is_claim_bonus', 6)
                        ->whereDate('approval_status_at', $today)->orderBy('approval_status_at', 'desc')->get();

                    if ($check_claim_bonus->toArray() != []) {
                        # Check Limit Claim Bonus
                        if (count($check_claim_bonus) >= $bonus_deposit->limit_claim) {
                            if ($check_claim_bonus) {
                                return $this->errorResponse("Maaf, Bonus Existing Member dapat diklaim sehari maksimal {$bonus_deposit->limit_claim} kali.", 400);
                            }
                        }

                        if ($turnoverMember) {
                            # Check the previous Turnover Bonus
                            if (($turnoverMember->turnover_member < $turnoverMember->turnover_target) && ($member->credit > 200)) {
                                return $this->errorResponse("Maaf, untuk Klaim Bonus Exising Member, Anda harus mencapai turnover bonus anda sebelumnya.", 400);
                            }
                        }

                    }

                    # Check Minimal Amount Deposit to Claim Bonus
                    if ($request->jumlah < $bonus_deposit->min_depo) {
                        return $this->errorResponse("Maaf, Minimal deposit untuk klaim bonus existing member sebesar " . number_format($bonus_deposit->min_depo) . ".", 400);
                    }
                    if ($request->jumlah > $bonus_deposit->max_depo) {
                        return $this->errorResponse("Maaf, Maksimal deposit untuk klaim bonus existing member sebesar " . number_format($bonus_deposit->max_depo) . ".", 400);
                    }
                } else {
                    return $this->errorResponse("Bonus Existing Member sedang tidak aktif.", 400);
                }
                $bonus = ($request->jumlah * $bonus_deposit->bonus_amount) / 100;
                $bonus = $bonus > $bonus_deposit->max_bonus ? $bonus_deposit->max_bonus : $bonus;
                $bonus_amount = $bonus_deposit->status_bonus == 1 ? $bonus : 0;
                $claimBonus = $bonus_deposit->status_bonus == 1 ? $request->is_claim_bonus : 0;
            }

            $active_rek = RekMemberModel::where([['created_by', $this->memberActive->id], ['is_depo', 1]])->first();
            $payload = [
                'rek_member_id' => $request->rekening_member_id,
                'members_id' => $this->memberActive->id,
                'rekening_id' => $request->rekening_id,
                'jumlah' => $request->jumlah,
                'credit' => $member->credit,
                'is_claim_bonus' => $claimBonus ?? 0,
                'bonus_amount' => $bonus_amount ?? 0,
                'note' => $request->note,
                'created_by' => $this->memberActive->id,
                'created_at' => Carbon::now(),
            ];

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

            $depositCreate = DepositModel::create($payload);

            # Create History Deposit
            DepositWithdrawHistory::create([
                'deposit_id' => $depositCreate->id,
                'member_id' => $depositCreate->members_id,
                'status' => 'Pending',
                'amount' => $depositCreate->jumlah,
                'credit' => $depositCreate->credit,
                'description' => 'Deposit : Pending',
                'created_by' => $this->memberActive->id,
            ]);

            // WEB SOCKET START
            // ==================================================================
            CreateDepositEvent::dispatch($depositCreate);
            // ==================================================================
            // WEB SOCKET FINISh

            $user = $this->memberActive;
            UserLogModel::logMemberActivity(
                'Deposit Created',
                $user,
                $depositCreate,
                [
                    'target' => 'Deposit',
                    'activity' => 'Create Deposit',
                    'ip_member' => $this->memberActive->last_login_ip,
                ],
                $user->username . ' Created a Deposit with amount ' . number_format($depositCreate->jumlah)
            );
            DB::commit();
            return $this->successResponse(null, 'Deposit berhasil');
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->errorResponse('Internal Server Error', 500, $th->getMessage());
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

    # Bonus New Member Promotion Setting
    public function settingBonusFreebet()
    {
        try {
            $userId = $this->memberActive->id;
            $dataSetting = BonusSettingModel::join('constant_bonus', 'constant_bonus.id', 'bonus_setting.constant_bonus_id')
                ->select(
                    'bonus_setting.id',
                    'constant_bonus.nama_bonus',
                    'bonus_setting.min_depo',
                    'bonus_setting.max_depo',
                    'bonus_setting.max_bonus',
                    'bonus_setting.bonus_amount',
                    'bonus_setting.turnover_x',
                    'bonus_setting.turnover_amount',
                    'bonus_setting.info',
                    'bonus_setting.status_bonus',
                    'bonus_setting.durasi_bonus_promo',
                    'bonus_setting.constant_provider_id',
                )->where('bonus_setting.constant_bonus_id', 4)->get();
            $dataBonusSetting = [];
            foreach ($dataSetting as $key => $item) {
                $provider_id = explode(',', $item->constant_provider_id);
                $providers = [];
                foreach ($provider_id as $key => $value) {
                    if ($value != 16) {
                        $providers[] = ConstantProvider::select('id', 'constant_provider_name as name')->find($value);
                    } else {
                        $providers[] = ['id' => 16, 'name' => 'Game Togel'];
                    }
                }
                $durasiBonus = $item->durasi_bonus_promo - 1;
                $subDay = Carbon::now()->subDays($durasiBonus)->format('Y-m-d 00:00:00');
                $today = Carbon::now()->format('Y-m-d 23:59:59');
                $checkKlaimBonus = DepositModel::select('bonus_amount', 'is_claim_bonus', 'status_bonus')
                    ->where('is_claim_bonus', 4)
                    ->where('status_bonus', 0)
                    ->where('approval_status', 1)
                    ->where('members_id', $userId)
                    ->whereBetween('approval_status_at', [$subDay, $today])->orderBy('approval_status_at', 'desc')
                    ->first();
                $cekSudahPernahDepo = DepositModel::where('members_id', $userId)->first();
                $dataBonusSetting[] = [
                    'id' => $item->id,
                    'name_bonus' => $item->nama_bonus,
                    'min_depo' => (float) $item->min_depo,
                    'max_depo' => (float) $item->max_depo,
                    'max_bonus' => (float) $item->max_bonus,
                    'bonus_amount' => (int) $item->bonus_amount,
                    'turnover_x' => $item->turnover_x,
                    'turnover_amount' => (float) $item->turnover_amount,
                    'bonus_amount_member' => $checkKlaimBonus->bonus_amount ?? 0,
                    'info' => $item->info,
                    'status_bonus' => $item->status_bonus,
                    'durasi_bonus_promo' => $item->durasi_bonus_promo,
                    'is_claim_bonus' => $checkKlaimBonus ? 1 : 0,
                    'provider_id' => $item->constant_provider_id ? $providers : [],
                    'is_new_member' => $cekSudahPernahDepo ? 0 : 1, // 1 = new member | 0 = existing member
                ];
            }
            return $this->successResponse($dataBonusSetting, 'Setting Bonus New Member berhasil ditampilkan');
        } catch (\Throwable $th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }

    # Bonus Existing Member Promotion Setting
    public function settingBonusDeposit()
    {
        try {
            $userId = $this->memberActive->id;
            $dataSetting = BonusSettingModel::join('constant_bonus', 'constant_bonus.id', 'bonus_setting.constant_bonus_id')
                ->select(
                    'bonus_setting.id',
                    'constant_bonus.nama_bonus',
                    'bonus_setting.min_depo',
                    'bonus_setting.max_depo',
                    'bonus_setting.bonus_amount',
                    'bonus_setting.max_bonus',
                    'bonus_setting.turnover_x',
                    'bonus_setting.turnover_amount',
                    'bonus_setting.info',
                    'bonus_setting.status_bonus',
                    'bonus_setting.durasi_bonus_promo',
                    'bonus_setting.constant_provider_id',
                )->where('bonus_setting.constant_bonus_id', 6)->get();
            $dataBonusSetting = [];
            foreach ($dataSetting as $key => $item) {
                $provider_id = explode(',', $item->constant_provider_id);
                $providers = [];
                foreach ($provider_id as $key => $value) {
                    if ($value != 16) {
                        $providers[] = ConstantProvider::select('id', 'constant_provider_name as name')->find($value);
                    } else {
                        $providers[] = ['id' => 16, 'name' => 'Game Togel'];
                    }
                }
                $durasiBonus = $item->durasi_bonus_promo - 1;
                $subDay = Carbon::now()->subDays($durasiBonus)->format('Y-m-d 00:00:00');
                $today = Carbon::now()->format('Y-m-d 23:59:59');
                $checkKlaimBonus = DepositModel::select('bonus_amount', 'is_claim_bonus', 'status_bonus')
                    ->where('is_claim_bonus', 6)
                    ->where('status_bonus', 0)
                    ->where('approval_status', 1)
                    ->where('members_id', $userId)
                    ->whereBetween('approval_status_at', [$subDay, $today])->orderBy('approval_status_at', 'desc')->first();

                $turnoverMember = TurnoverMember::where('member_id', $userId)->where('constant_bonus_id', 6)->where('status', false)
                    ->whereBetween('created_at', [$subDay, $today])
                    ->whereRaw("IF(turnover_member < turnover_target, true, false)")
                    ->orderBy('id', 'desc')->first();

                $member = MembersModel::select(['id', 'credit'])->find($userId);

                $canClaimAgain = $item->status_bonus == 1 && $turnoverMember && $member->credit > 200 ? 0 : $item->status_bonus;

                $dataBonusSetting[] = [
                    'id' => $item->id,
                    'name_bonus' => $item->nama_bonus,
                    'min_depo' => (float) $item->min_depo,
                    'max_depo' => (float) $item->max_depo,
                    'max_bonus' => (float) $item->max_bonus,
                    'bonus_amount' => (int) $item->bonus_amount,
                    'turnover_x' => $item->turnover_x,
                    'turnover_amount' => (float) $item->turnover_amount,
                    'bonus_amount_member' => $checkKlaimBonus->bonus_amount ?? 0,
                    'info' => $item->info,
                    'status_bonus' => $item->status_bonus,
                    'can_claim_again' => $canClaimAgain,
                    'durasi_bonus_promo' => $item->durasi_bonus_promo,
                    'is_claim_bonus' => $checkKlaimBonus ? 1 : 0,
                    'provider_id' => $item->constant_provider_id ? $providers : [],
                ];
            }
            return $this->successResponse($dataBonusSetting, 'Setting Bonus Existing Member berhasil ditampilkan');
        } catch (\Throwable $th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }

    # Bonus New Member Promotion
    public function freebetBonus()
    {
        try {
            $bonus_freebet = BonusSettingModel::select(
                'min_depo',
                'max_depo',
                'bonus_amount',
                'turnover_x',
                'turnover_amount',
                'info',
                'status_bonus',
                'durasi_bonus_promo',
                'constant_provider_id',
            )->where('constant_bonus_id', 4)->first();
            $durasiBonus = $bonus_freebet->durasi_bonus_promo - 1;
            // $subDay = Carbon::now()->subDays($durasiBonus)->format('Y-m-d 00:00:00');
            // $today = Carbon::now()->format('Y-m-d 23:59:59');

            /**
             * Check if bonus is active and New member bonus has been approved in deposit
             */
            if ($bonus_freebet->status_bonus == 1) {
                $checkBonusNewMember = TurnoverMember::leftJoin('deposit', 'deposit.id', 'turnover_members.deposit_id')
                    ->select([
                        'turnover_members.id',
                        'turnover_members.deposit_id',
                        'turnover_members.turnover_target',
                        'turnover_members.turnover_member',
                        'turnover_members.deposit_id',
                        'turnover_members.member_id',
                        'turnover_members.status',
                        'deposit.approval_status_at',
                        'deposit.jumlah',
                        'deposit.bonus_amount',
                    ])
                    ->where('turnover_members.member_id', $this->memberActive->id)->where('turnover_members.constant_bonus_id', 4)->first();
                if (!$checkBonusNewMember) {
                    $Check_deposit_claim_bonus_freebet = DepositModel::where('members_id', $this->memberActive->id)
                        ->where('approval_status', 1)
                        ->where('is_claim_bonus', 4)
                    // ->whereBetween('approval_status_at', [$subDay, $today])
                        ->orderBy('approval_status_at', 'desc')
                        ->first();

                    if ($Check_deposit_claim_bonus_freebet) {

                        $withdraw = WithdrawModel::where('members_id', $this->memberActive->id)
                            ->whereRaw("IF(is_claim_bonus = 0, deposit_id like ?, is_claim_bonus = 4
                            )", ["%,{$Check_deposit_claim_bonus_freebet->id},%"])
                            ->first();

                        $date = $withdraw ? $withdraw->created_at : now();
                        $providerId = explode(',', $bonus_freebet->constant_provider_id);
                        if (!in_array(16, $providerId)) {
                            $TOSlotCasinoFish = BetModel::whereIn('type', ['Win', 'Lose', 'Bet', 'Settle'])
                                ->whereBetween('created_at', [$Check_deposit_claim_bonus_freebet->approval_status_at, $date])
                                ->where('created_by', $this->memberActive->id)
                                ->whereIn('constant_provider_id', $providerId)->sum('bet');

                            $TOMember = $TOSlotCasinoFish;
                        } else {
                            $TOSlotCasinoFish = BetModel::whereIn('type', ['Win', 'Lose', 'Bet', 'Settle'])
                                ->whereBetween('created_at', [$Check_deposit_claim_bonus_freebet->approval_status_at, $date])
                                ->where('created_by', $this->memberActive->id)
                                ->whereIn('constant_provider_id', $providerId)->sum('bet');
                            $TOTogel = BetsTogel::whereBetween('created_at', [$Check_deposit_claim_bonus_freebet->approval_status_at, $date])
                                ->where('created_by', $this->memberActive->id)->sum('pay_amount');

                            $TOMember = $TOSlotCasinoFish + $TOTogel;
                        }

                        $total_depo = $Check_deposit_claim_bonus_freebet->jumlah;
                        $total_bonus = $Check_deposit_claim_bonus_freebet->bonus_amount;
                        $turnover_x = $bonus_freebet->turnover_x;
                        $bonus_amount = $bonus_freebet->bonus_amount;

                        $TO = ($total_depo + $total_bonus) * $turnover_x;
                        /**
                         * Check if status new member bonus has been rejected.
                         * Status bonus in DB -> 0 = Default, 1 = Approve, 2 = Reject
                         */
                        if ($Check_deposit_claim_bonus_freebet->status_bonus == 2) {
                            $status = preg_match("/menyerah/i", $Check_deposit_claim_bonus_freebet->reason_bonus) ? 'Menyerah' : 'Gagal';
                            $date = $Check_deposit_claim_bonus_freebet->approval_status_at;
                            $dateClaim = Carbon::parse($date)->addDays($durasiBonus + 1)->format('Y-m-d 00:00:00');
                            $data = [
                                'turnover' => (float) $TO,
                                'turnover_member' => (float) $TOMember,
                                // 'durasi_bonus_promo' => $bonus_freebet->durasi_bonus_promo, // remove duration for New Member Bonus
                                'status_bonus' => $bonus_freebet->status_bonus,
                                'is_claim_bonus' => $Check_deposit_claim_bonus_freebet->is_claim_bonus,
                                'bonus_amount' => $Check_deposit_claim_bonus_freebet->bonus_amount,
                                'status_bonus_member' => $status,
                                // 'date_claim_again' => $dateClaim, // remove duration for New Member Bonus
                            ];
                        } else {
                            $status = $Check_deposit_claim_bonus_freebet->status_bonus == 0 ? 'Klaim' : 'Selesai';
                            $date = $Check_deposit_claim_bonus_freebet->approval_status_at;
                            $dateClaim = Carbon::parse($date)->addDays($durasiBonus + 1)->format('Y-m-d 00:00:00');
                            $data = [
                                'turnover' => $TO,
                                'turnover_member' => $TOMember,
                                // 'durasi_bonus_promo' => $bonus_freebet->durasi_bonus_promo, // remove duration for New Member Bonus
                                'status_bonus' => $bonus_freebet->status_bonus,
                                'is_claim_bonus' => $Check_deposit_claim_bonus_freebet->is_claim_bonus,
                                'bonus_amount' => $Check_deposit_claim_bonus_freebet->bonus_amount,
                                'status_bonus_member' => $status,
                                // 'date_claim_again' => $dateClaim, // remove duration for New Member Bonus
                            ];
                        }

                    } else {
                        /**
                         * Bonus is nothing
                         */
                        $data = [
                            'turnover' => 0,
                            'turnover_member' => 0,
                            // 'durasi_bonus_promo' => 0, // remove duration for New Member Bonus
                            'status_bonus' => 0,
                            'is_claim_bonus' => 0,
                            'bonus_amount' => 0,
                            'status_bonus_member' => null,
                            // 'date_claim_again' => null, // remove duration for New Member Bonus
                        ];
                    }
                } else {
                    $TO = $checkBonusNewMember->turnover_target;
                    $TOMember = $checkBonusNewMember->turnover_member;
                    $status = $checkBonusNewMember->status == 0 ? 'Klaim' : ($checkBonusNewMember->status == 1 ? 'Selesai' : ($checkBonusNewMember->status == 2 ? 'Menyerah' : 'Gagal'));
                    $data = [
                        'turnover' => (float) $TO,
                        'turnover_member' => (float) $TOMember,
                        'status_bonus' => $bonus_freebet->status_bonus,
                        'is_claim_bonus' => 4,
                        'bonus_amount' => $checkBonusNewMember->bonus_amount,
                        'status_bonus_member' => $status,
                    ];
                }
            } else {
                /**
                 * Bonus is not active
                 */
                $data = [
                    'turnover' => 0,
                    'turnover_member' => 0,
                    // 'durasi_bonus_promo' => 0, // remove duration for New Member Bonus
                    'status_bonus' => 0,
                    'is_claim_bonus' => 0,
                    'bonus_amount' => 0,
                    'status_bonus_member' => null,
                    // 'date_claim_again' => null, // remove duration for New Member Bonus
                ];
            }
            return $this->successResponse([$data], 'Datanya ada', 200);
        } catch (\Throwable $th) {
            return $this->errorResponse('Internal Server Error', 500, $th->getMessage());
        }
    }

    # Bonus Existing Member Promotion
    public function depositBonus()
    {
        try {
            $bonus_deposit = BonusSettingModel::select(
                'min_depo',
                'max_depo',
                'bonus_amount',
                'max_bonus',
                'turnover_x',
                'turnover_amount',
                'info',
                'status_bonus',
                'durasi_bonus_promo',
                'constant_provider_id',
            )->where('constant_bonus_id', 6)->first();
            $durasiBonus = $bonus_deposit->durasi_bonus_promo - 1;
            $subDay = Carbon::now()->subDays($durasiBonus)->format('Y-m-d 00:00:00');
            $today = Carbon::now()->format('Y-m-d 23:59:59');

            # Check Claim Bonus Existing Member

            if ($bonus_deposit->status_bonus == 1) {
                $checkBonusExisting = TurnoverMember::leftJoin('deposit', 'deposit.id', 'turnover_members.deposit_id')
                    ->select([
                        'turnover_members.id',
                        'turnover_members.deposit_id',
                        'turnover_members.withdraw_id',
                        'turnover_members.turnover_target',
                        'turnover_members.turnover_member',
                        'turnover_members.deposit_id',
                        'turnover_members.member_id',
                        'turnover_members.status',
                        'deposit.approval_status_at',
                        'deposit.jumlah',
                        'deposit.bonus_amount',
                    ])
                    ->where('turnover_members.member_id', $this->memberActive->id)->where('turnover_members.constant_bonus_id', 6)
                    ->whereBetween('deposit.approval_status_at', [$subDay, $today])->orderBy('turnover_members.created_at', 'desc')->get();

                $datas = [];
                if ($checkBonusExisting->toArray() == []) {
                    $Check_deposit_claim_bonus_exisiting = DepositModel::where('members_id', $this->memberActive->id)
                        ->where('approval_status', 1)
                        ->where('is_claim_bonus', 6)
                        ->whereBetween('approval_status_at', [$subDay, $today])->orderBy('approval_status_at', 'desc')->get();

                    $providerId = explode(',', $bonus_deposit->constant_provider_id);
                    foreach ($Check_deposit_claim_bonus_exisiting as $key => $existingMemberBonus) {
                        $withdraw = WithdrawModel::where('members_id', $this->memberActive->id)
                            ->whereRaw("IF(is_claim_bonus = 0, deposit_id like ?, is_claim_bonus = 6
                                )", ["%,{$existingMemberBonus->id},%"])
                            ->first();

                        $date = $withdraw ? $withdraw->created_at : now();
                        if (!in_array(16, $providerId)) {
                            $TOSlotCasinoFish = BetModel::whereIn('type', ['Win', 'Lose', 'Bet', 'Settle'])
                                ->whereBetween('created_at', [$existingMemberBonus->approval_status_at, $date])
                                ->where('created_by', $this->memberActive->id)
                                ->whereIn('constant_provider_id', $providerId)->sum('bet');

                            $TOMember = $TOSlotCasinoFish;
                        } else {
                            $TOSlotCasinoFish = BetModel::whereIn('type', ['Win', 'Lose', 'Bet', 'Settle'])
                                ->whereBetween('created_at', [$existingMemberBonus->approval_status_at, $date])
                                ->where('created_by', $this->memberActive->id)
                                ->whereIn('constant_provider_id', $providerId)->sum('bet');
                            $TOTogel = BetsTogel::whereBetween('created_at', [$existingMemberBonus->approval_status_at, $date])
                                ->where('created_by', $this->memberActive->id)->sum('pay_amount');

                            $TOMember = $TOSlotCasinoFish + $TOTogel;
                        }

                        $total_depo = $existingMemberBonus->jumlah;
                        $total_bonus = $existingMemberBonus->bonus_amount;
                        $turnover_x = $bonus_deposit->turnover_x;
                        $bonus_amount = $bonus_deposit->bonus_amount;

                        /**
                         * Below is to make the Turnover Target is same with TO on Member's side in Account > Bonus.
                         */
                        $TO = ($total_depo + $total_bonus) * $turnover_x;

                        if ($existingMemberBonus->status_bonus == 2) {
                            $status = preg_match("/menyerah/i", $existingMemberBonus->reason_bonus) ? 'Menyerah' : 'Gagal';
                            $date = $existingMemberBonus->approval_status_at;
                            $dateClaim = Carbon::parse($date)->addDays($durasiBonus + 1)->format('Y-m-d 00:00:00');
                            $datas[] = [
                                'turnover' => (float) $TO,
                                'turnover_member' => (float) $TOMember,
                                'durasi_bonus_promo' => $bonus_deposit->durasi_bonus_promo,
                                'status_bonus' => $bonus_deposit->status_bonus,
                                'is_claim_bonus' => $existingMemberBonus->is_claim_bonus,
                                'deposit_amount' => $existingMemberBonus->jumlah,
                                'bonus_amount' => $existingMemberBonus->bonus_amount,
                                'status_bonus_member' => $status,
                                'date_claim_again' => $dateClaim,
                                'depositID' => $existingMemberBonus->id,
                            ];
                        } else {
                            $status = $existingMemberBonus->status_bonus == 0 ? 'Klaim' : 'Selesai';
                            $date = $existingMemberBonus->approval_status_at;
                            $dateClaim = Carbon::parse($date)->addDays($durasiBonus + 1)->format('Y-m-d 00:00:00');
                            $datas[] = [
                                'turnover' => (float) $TO,
                                'turnover_member' => (float) $TOMember,
                                'durasi_bonus_promo' => $bonus_deposit->durasi_bonus_promo,
                                'status_bonus' => $bonus_deposit->status_bonus,
                                'is_claim_bonus' => $existingMemberBonus->is_claim_bonus,
                                'deposit_amount' => $existingMemberBonus->jumlah,
                                'bonus_amount' => $existingMemberBonus->bonus_amount,
                                'status_bonus_member' => $status,
                                'date_claim_again' => $dateClaim,
                                'depositID' => $existingMemberBonus->id,
                            ];

                        }
                    }
                } else {
                    foreach ($checkBonusExisting as $key => $existingMemberBonus) {
                        $status = $existingMemberBonus->status == 0 && $existingMemberBonus->turnover_target > $existingMemberBonus->turnover_member ? 'Klaim' :
                        ($existingMemberBonus->status == 0 && $existingMemberBonus->turnover_target <= $existingMemberBonus->turnover_member ? 'Capai TO' :
                            ($existingMemberBonus->status == 1 && $existingMemberBonus->withdraw_id != null ? 'Selesai' :
                                ($existingMemberBonus->status == 2 ? 'Menyerah' : 'Gagal')));
                        $date = $existingMemberBonus->approval_status_at;
                        $dateClaim = Carbon::parse($date)->addDays($durasiBonus + 1)->format('Y-m-d 00:00:00');
                        $TO = (float) $existingMemberBonus->turnover_target;
                        $TOMember = (float) $existingMemberBonus->turnover_member;
                        $datas[] = [
                            'turnover' => $TO,
                            'turnover_member' => $TOMember,
                            'durasi_bonus_promo' => $bonus_deposit->durasi_bonus_promo,
                            'status_bonus' => $bonus_deposit->status_bonus,
                            'is_claim_bonus' => 6,
                            'deposit_amount' => $existingMemberBonus->jumlah,
                            'bonus_amount' => $existingMemberBonus->bonus_amount,
                            'status_bonus_member' => $status,
                            'date_claim_again' => $dateClaim,
                            'depositID' => $existingMemberBonus->deposit_id,
                        ];
                    }
                }
                if ($datas == []) {
                    $datas = [
                        [
                            'turnover' => 0,
                            'turnover_member' => 0,
                            'durasi_bonus_promo' => 0,
                            'status_bonus' => 0,
                            'is_claim_bonus' => 0,
                            'deposit_amount' => 0,
                            'bonus_amount' => 0,
                            'status_bonus_member' => null,
                            'date_claim_again' => null,
                            'depositID' => null,
                        ],
                    ];
                }
            } else {
                $datas = [
                    [
                        'turnover' => 0,
                        'turnover_member' => 0,
                        'durasi_bonus_promo' => 0,
                        'status_bonus' => 0,
                        'is_claim_bonus' => 0,
                        'deposit_amount' => 0,
                        'bonus_amount' => 0,
                        'status_bonus_member' => null,
                        'date_claim_again' => null,
                        'depositID' => null,
                    ],
                ];
            }
            return $this->successResponse($datas, 'Datanya ada', 200);
        } catch (\Throwable $th) {
            return $this->errorResponse('Internal Server Error', 500, $th->getMessage());
        }
    }

    # Bonus New Member Promotion Give Up
    // Temporary not used
    // public function BonusFreebetGivUp(Request $request)
    // {
    //     try {
    //         $memberId = $this->memberActive->id;
    //         $constantBonus = ConstantBonusModel::select('nama_bonus')->find(4);

    //         $bonus_freebet = BonusSettingModel::select(
    //             'min_depo',
    //             'max_depo',
    //             'bonus_amount',
    //             'turnover_x',
    //             'turnover_amount',
    //             'info',
    //             'status_bonus',
    //             // 'durasi_bonus_promo', **remove duration for New Member Bonus
    //             'constant_provider_id',
    //         )->where('constant_bonus_id', 4)->first();
    //         $Check_deposit_claim_bonus_freebet = DepositModel::where('members_id', $this->memberActive->id)
    //             ->where('approval_status', 1)
    //             ->where('is_claim_bonus', 4)
    //             ->where('status_bonus', 0)->orderBy('approval_status_at', 'asc')
    //             ->first();
    //         if ($bonus_freebet->status_bonus == 1 && $Check_deposit_claim_bonus_freebet) {
    //             $currentCreditMember = MembersModel::where('id', $this->memberActive->id)->first()->credit;
    //             $bonusGiven = $Check_deposit_claim_bonus_freebet->bonus_amount;
    //             if ($currentCreditMember < $bonusGiven) {
    //                 return $this->errorResponse("Maaf, Anda tidak dapat menyerah, karena Anda telah memakai {$constantBonus->nama_bonus}", 400);
    //             }

    //             $providerId = explode(',', $bonus_freebet->constant_provider_id);
    //             if (!in_array(16, $providerId)) {
    //                 $TOSlotCasinoFish = BetModel::whereIn('type', ['Win', 'Lose', 'Bet', 'Settle'])
    //                     ->whereBetween('created_at', [$Check_deposit_claim_bonus_freebet->approval_status_at, now()])
    //                     ->where('created_by', $this->memberActive->id)
    //                     ->whereIn('constant_provider_id', $providerId)->sum('bet');

    //                 $TOmember = $TOSlotCasinoFish;
    //             } else {
    //                 $TOSlotCasinoFish = BetModel::whereIn('type', ['Win', 'Lose', 'Bet', 'Settle'])
    //                     ->whereBetween('created_at', [$Check_deposit_claim_bonus_freebet->approval_status_at, now()])
    //                     ->where('created_by', $this->memberActive->id)
    //                     ->whereIn('constant_provider_id', $providerId)->sum('bet');
    //                 $TOTogel = BetsTogel::whereBetween('created_at', [$Check_deposit_claim_bonus_freebet->approval_status_at, now()])
    //                     ->where('created_by', $this->memberActive->id)->sum('pay_amount');

    //                 $TOmember = $TOSlotCasinoFish + $TOTogel;
    //             }

    //             $total_depo = $Check_deposit_claim_bonus_freebet->jumlah;
    //             $total_bonus = $Check_deposit_claim_bonus_freebet->bonus_amount;
    //             $turnover_x = $bonus_freebet->turnover_x;
    //             $bonus_amount = $bonus_freebet->bonus_amount;

    //             $TO = ($total_depo + $total_bonus) * $turnover_x;

    //             if ($TOmember > $TO) {
    //                 return $this->errorResponse("Maaf, Anda tidak dapat menyerah, karena Anda telah mencapai TO (Turnover) {$constantBonus->nama_bonus} Promotion, silahkan Withdraw sekarang", 400);
    //             }

    //             $bonus = $Check_deposit_claim_bonus_freebet->bonus_amount;
    //             $member = MembersModel::where('id', $memberId)->first();
    //             $credit = $member->credit - $bonus;

    //             MembersModel::where('id', $memberId)
    //                 ->update([
    //                     'credit' => $credit,
    //                     'updated_by' => $this->memberActive->id,
    //                     'updated_at' => Carbon::now(),
    //                 ]);

    //             DepositModel::where('id', $Check_deposit_claim_bonus_freebet->id)
    //                 ->update([
    //                     'status_bonus' => 2,
    //                     'reason_bonus' => 'anda menyerah untuk mencapai TO (Turn Over) sebesar Rp. ' . $TO,
    //                     'updated_by' => $this->memberActive->id,
    //                     'updated_at' => Carbon::now(),
    //                 ]);

    //             $bonusHistory = BonusHistoryModel::create([
    //                 'is_send' => 1,
    //                 'is_use' => 1,
    //                 'is_delete' => 0,
    //                 'constant_bonus_id' => 4,
    //                 'jumlah' => $bonus * -1,
    //                 'credit' => MembersModel::where('id', $memberId)->first()->credit,
    //                 'member_id' => $this->memberActive->id,
    //                 'hadiah' => 'Anda menyerah untuk mencapai TO (Turn Over) sebesar Rp. ' . number_format($TO) . ',  bonus sebesar Rp. ' . number_format($bonus) . ' kami tarik kembali, dari balance anda.',
    //                 'type' => 'uang',
    //                 'created_by' => 0,
    //                 'created_at' => Carbon::now(),
    //             ]);

    //             # Create Report Bonus History
    //             BonusHistoryReport::create([
    //                 'bonus_history_id' => $bonusHistory->id,
    //                 'constant_bonus_id' => 4,
    //                 'name_bonus' => $constantBonus->nama_bonus,
    //                 'member_id' => $bonusHistory->member_id,
    //                 'member_username' => $member->username,
    //                 'credit' => $bonusHistory->credit,
    //                 'user_id' => 0,
    //                 'user_username' => 'System',
    //                 'jumlah' => $bonusHistory->jumlah,
    //                 'hadiah' => $bonusHistory->hadiah,
    //                 'status' => 'Menyerah',
    //                 'created_by' => 0,
    //                 'bonus_date' => $bonusHistory->created_at,
    //             ]);

    //             $createMemo = MemoModel::create([
    //                 'member_id' => $this->memberActive->id,
    //                 'sender_id' => 0,
    //                 'send_type' => 'System',
    //                 'subject' => $constantBonus->nama_bonus,
    //                 'is_reply' => 1,
    //                 'is_bonus' => 1,
    //                 'content' => 'Maaf Anda tidak memenuhi persyaratan mengklaim ' . $constantBonus->nama_bonus . ', Anda menyerah untuk mencapai TO (Turn Over) sebesar Rp. ' . number_format($TO) . ',  bonus sebesar Rp. ' . number_format($bonus) . ' kami tarik kembali, dari balance anda.',
    //                 'created_at' => Carbon::now(),
    //             ]);

    //             // WEB SOCKET START
    //             // ========================================
    //             NotifyNewMemoEvent::dispatch($createMemo);
    //             // ========================================
    //             // WEB SOCKET FINISH

    //             UserLogModel::logMemberActivity(
    //                 $constantBonus->nama_bonus . ' Giveup',
    //                 $member,
    //                 $Check_deposit_claim_bonus_freebet,
    //                 [
    //                     'target' => $constantBonus->nama_bonus,
    //                     'activity' => $constantBonus->nama_bonus . ' Giveup',
    //                     'ip_member' => $this->memberActive->last_login_ip,
    //                 ],
    //                 $member->username . ' Deducted ' . $constantBonus->nama_bonus . ' amount from member balance  ' . number_format($bonus)
    //             );

    //             // WEB SOCKET START
    //             GiveUpBonusEvent::dispatch(MembersModel::select('id', 'credit', 'username')->find($memberId)->toArray());
    //             // WEB SOCKET FINISH

    //             return response()->json([
    //                 'status' => 'success',
    //                 'message' => 'Penyerahan Bonus New Member berhasil.',
    //             ]);
    //         }

    //         return $this->errorResponse("Maaf, Bonus New Member sudah tidak aktif atau kadaluarsa.", 400);

    //     } catch (\Throwable $th) {
    //         return $this->errorResponse('Internal Server Error', 500, $th->getMessage());
    //     }
    // }

    # Bonus Existing Member Promotion Give Up
    public function BonusDepositGivUp(Request $request, $depositID)
    {
        try {
            $memberId = $this->memberActive->id;
            $constantBonus = ConstantBonusModel::select('nama_bonus')->find(6);

            $bonus_deposit = BonusSettingModel::select(
                'min_depo',
                'max_depo',
                'bonus_amount',
                'turnover_x',
                'turnover_amount',
                'info',
                'status_bonus',
                'durasi_bonus_promo',
                'constant_provider_id',
                'max_bonus'
            )->where('constant_bonus_id', 6)->first();
            $durasiBonus = $bonus_deposit->durasi_bonus_promo - 1;
            $subDay = Carbon::now()->subDays($durasiBonus)->format('Y-m-d 00:00:00');
            $today = Carbon::now()->format('Y-m-d 23:59:59');
            $Check_deposit_claim_bonus_deposit = DepositModel::where('members_id', $this->memberActive->id)
                ->where('approval_status', 1)
                ->where('is_claim_bonus', 6)
                ->where('status_bonus', 0)
                ->where('id', $depositID)
                ->whereBetween('approval_status_at', [$subDay, $today])
                ->orderBy('approval_status_at', 'desc')
                ->first();

            if ($bonus_deposit->status_bonus == 1 && $Check_deposit_claim_bonus_deposit) {
                $currentCreditMember = MembersModel::where('id', $this->memberActive->id)->first()->credit;
                $bonusGiven = $Check_deposit_claim_bonus_deposit->bonus_amount;

                # Check bonuses that have been used
                if ($currentCreditMember < $bonusGiven) {
                    return $this->errorResponse("Maaf, Anda tidak dapat menyerah, karena Anda telah memakai {$constantBonus->nama_bonus}", 400);
                }

                $checkBonusExisting = TurnoverMember::where('member_id', $memberId)
                    ->where('deposit_id', $depositID)
                    ->where('constant_bonus_id', 6)
                    ->where('status', false)->first();
                if ($checkBonusExisting) {
                    $TOmember = $checkBonusExisting->turnover_member;
                    $TO = $checkBonusExisting->turnover_target;
                } else {
                    $providerId = explode(',', $bonus_deposit->constant_provider_id);
                    if (!in_array(16, $providerId)) {
                        $TOSlotCasinoFish = BetModel::whereIn('type', ['Win', 'Lose', 'Bet', 'Settle'])
                            ->whereBetween('created_at', [$Check_deposit_claim_bonus_deposit->approval_status_at, now()])
                            ->where('created_by', $this->memberActive->id)
                            ->whereIn('constant_provider_id', $providerId)->sum('bet');

                        $TOmember = $TOSlotCasinoFish;
                    } else {
                        $TOSlotCasinoFish = BetModel::whereIn('type', ['Win', 'Lose', 'Bet', 'Settle'])
                            ->whereBetween('created_at', [$Check_deposit_claim_bonus_deposit->approval_status_at, now()])
                            ->where('created_by', $this->memberActive->id)
                            ->whereIn('constant_provider_id', $providerId)->sum('bet');
                        $TOTogel = BetsTogel::whereBetween('created_at', [$Check_deposit_claim_bonus_deposit->approval_status_at, now()])
                            ->where('created_by', $this->memberActive->id)->sum('pay_amount');

                        $TOmember = $TOSlotCasinoFish + $TOTogel;
                    }

                    $total_depo = $Check_deposit_claim_bonus_deposit->jumlah;
                    $total_bonus = $Check_deposit_claim_bonus_deposit->bonus_amount;
                    $turnover_x = $bonus_deposit->turnover_x;
                    $bonus_amount = $bonus_deposit->bonus_amount;

                    /**
                     * Below is to make the Turnover Target is same with TO on Member's side in Account > Bonus.
                     */
                    $TO = ($total_depo + $total_bonus) * $turnover_x;
                }

                if ($TOmember >= $TO) {
                    return $this->errorResponse("Maaf, Anda tidak dapat menyerah, karena Anda telah mencapai TO (Turnover) {$constantBonus->nama_bonus}, silahkan Withdraw sekarang", 400);
                }

                if ($checkBonusExisting) {
                    $checkBonusExisting->update([
                        'status' => 2,
                    ]);
                }

                $bonus = $Check_deposit_claim_bonus_deposit->bonus_amount;
                $member = MembersModel::where('id', $memberId)->first();
                $credit = $member->credit - $bonus;

                MembersModel::where('id', $memberId)
                    ->update([
                        'credit' => $credit,
                        'updated_by' => $this->memberActive->id,
                        'updated_at' => Carbon::now(),
                    ]);

                DepositModel::where('id', $Check_deposit_claim_bonus_deposit->id)
                    ->update([
                        'status_bonus' => 2,
                        'reason_bonus' => 'anda menyerah untuk mencapai TO (Turn Over) sebesar Rp. ' . $TO,
                        'updated_by' => $this->memberActive->id,
                        'updated_at' => Carbon::now(),
                    ]);

                $bonusHistory = BonusHistoryModel::create([
                    'is_send' => 1,
                    'is_use' => 1,
                    'is_delete' => 0,
                    'constant_bonus_id' => 6,
                    'jumlah' => $bonus * -1,
                    'credit' => MembersModel::where('id', $memberId)->first()->credit,
                    'member_id' => $this->memberActive->id,
                    'hadiah' => 'Anda menyerah untuk mencapai TO (Turn Over) sebesar Rp. ' . number_format($TO) . ',  bonus sebesar Rp. ' . number_format($bonus) . ' kami tarik kembali, dari balance anda.',
                    'type' => 'uang',
                    'created_by' => 0,
                    'created_at' => Carbon::now(),
                ]);

                # Create Report Bonus History
                BonusHistoryReport::create([
                    'bonus_history_id' => $bonusHistory->id,
                    'constant_bonus_id' => 6,
                    'name_bonus' => $constantBonus->nama_bonus,
                    'member_id' => $bonusHistory->member_id,
                    'member_username' => $member->username,
                    'credit' => $bonusHistory->credit,
                    'user_id' => 0,
                    'user_username' => 'System',
                    'jumlah' => $bonusHistory->jumlah,
                    'hadiah' => $bonusHistory->hadiah,
                    'status' => 'Menyerah',
                    'created_by' => 0,
                    'bonus_date' => $bonusHistory->created_at,
                ]);

                $createMemo = MemoModel::create([
                    'member_id' => $this->memberActive->id,
                    'sender_id' => 0,
                    'send_type' => 'System',
                    'subject' => $constantBonus->nama_bonus,
                    'is_reply' => 1,
                    'is_bonus' => 1,
                    'content' => 'Maaf Anda tidak memenuhi persyaratan mengklaim ' . $constantBonus->nama_bonus . ', Anda menyerah untuk mencapai TO (Turn Over) sebesar Rp. ' . number_format($TO) . ',  bonus sebesar Rp. ' . number_format($bonus) . ' kami tarik kembali, dari balance anda.',
                    'created_at' => Carbon::now(),
                ]);

                // WEB SOCKET START
                // ========================================
                NotifyNewMemoEvent::dispatch($createMemo);
                // ========================================
                // WEB SOCKET FINISH

                UserLogModel::logMemberActivity(
                    $constantBonus->nama_bonus . ' Giveup',
                    $member,
                    $Check_deposit_claim_bonus_deposit,
                    [
                        'target' => $constantBonus->nama_bonus,
                        'activity' => $constantBonus->nama_bonus . ' Giveup',
                        'ip_member' => $this->memberActive->last_login_ip,
                    ],
                    $member->username . ' Deducted ' . $constantBonus->nama_bonus . ' amount from member balance  ' . number_format($bonus)
                );

                // WEB SOCKET START
                GiveUpBonusEvent::dispatch(MembersModel::select('id', 'credit', 'username')->find($memberId)->toArray());
                // WEB SOCKET FINISH

                return response()->json([
                    'status' => 'success',
                    'message' => 'Penyerahan Bonus Existing Member berhasil.',
                ]);
            }

            return $this->errorResponse("Maaf, Bonus Existing Member sudah tidak aktif atau kadaluarsa.", 400);

        } catch (\Throwable $th) {
            return $this->errorResponse('Internal Server Error', 500, $th->getMessage());
        }
    }
}
