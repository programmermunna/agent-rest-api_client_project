<?php

namespace App\Http\Controllers\Api\v1;

use App\Events\BotDanaEvent;
use App\Events\CreateDepositEvent;
use App\Http\Controllers\ApiController;
use App\Models\BetModel;
use App\Models\BetsTogel;
use App\Models\BonusHistoryModel;
use App\Models\BonusSettingModel;
use App\Models\ConstantProvider;
use App\Models\DepositModel;
use App\Models\MembersModel;
use App\Models\MemoModel;
use App\Models\RekeningModel;
use App\Models\RekMemberModel;
use App\Models\UserLogModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DepositController extends ApiController
{
    public $memberActive;

    public function __construct()
    {
        try {
            $this->memberActive = auth('api')->user();
        } catch (\Throwable$th) {
            return $this->errorResponse('Token is Invalid or Expired', 401);
        }
    }

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

            if ($request->is_claim_bonus == 4) {
                $bonus_freebet = BonusSettingModel::select('status_bonus', 'durasi_bonus_promo', 'min_depo', 'max_depo', 'bonus_amount')->where('constant_bonus_id', $request->is_claim_bonus)->first();
                $durasiBonus = $bonus_freebet->durasi_bonus_promo - 1;
                $subDay = Carbon::now()->subDays($durasiBonus)->format('Y-m-d 00:00:00');
                $today = Carbon::now()->format('Y-m-d 23:59:59');
                $check_claim_bonus = DepositModel::where('members_id', $this->memberActive->id)
                    ->where('approval_status', 1)
                    ->whereIn('is_claim_bonus', [4, 6])
                    ->whereBetween('approval_status_at', [$subDay, $today])->orderBy('approval_status_at', 'desc')->first();
                if ($bonus_freebet->status_bonus == 1) {
                    if ($check_claim_bonus) {
                        if ($check_claim_bonus->is_claim_bonus == 4) {
                            return $this->errorResponse("Maaf, Bonus Freebet dapat diklaim sehari sekali.", 400);
                        }
                        if ($check_claim_bonus->is_claim_bonus == 6) {
                            return $this->errorResponse("Maaf, Bonus Freebet tidak dapat diklaim, Anda sudah mengklaim Bonus Deposit hari ini.", 400);
                        }
                    }
                    if ($request->jumlah < $bonus_freebet->min_depo) {
                        return $this->errorResponse("Maaf, Minimal deposit untuk klaim bonus freebet sebesar " . number_format($bonus_freebet->min_depo) . ".", 400);
                    }
                    if ($request->jumlah > $bonus_freebet->max_depo) {
                        return $this->errorResponse("Maaf, Maksimal deposit untuk klaim bonus freebet sebesar " . number_format($bonus_freebet->max_depo) . ".", 400);
                    }
                } else {
                    return $this->errorResponse("Bonus Freebet sedang tidak aktif.", 400);
                }
                $bonus = ($request->jumlah * $bonus_freebet->bonus_amount) / 100;
                $bonus_amount = $bonus_freebet->status_bonus == 1 ? $bonus : 0;
                $claimBonus = $bonus_freebet->status_bonus == 1 ? $request->is_claim_bonus : 0;
            }
            if ($request->is_claim_bonus == 6) {
                $bonus_deposit = BonusSettingModel::select('status_bonus', 'durasi_bonus_promo', 'min_depo', 'max_depo', 'bonus_amount', 'max_bonus')->where('constant_bonus_id', $request->is_claim_bonus)->first();
                $durasiBonus = $bonus_deposit->durasi_bonus_promo - 1;
                $subDay = Carbon::now()->subDays($durasiBonus)->format('Y-m-d 00:00:00');
                $today = Carbon::now()->format('Y-m-d 23:59:59');
                $check_claim_bonus = DepositModel::where('members_id', $this->memberActive->id)
                    ->where('approval_status', 1)
                    ->whereIn('is_claim_bonus', [4, 6])
                    ->whereBetween('approval_status_at', [$subDay, $today])->orderBy('approval_status_at', 'desc')->first();
                if ($bonus_deposit->status_bonus == 1) {
                    if ($check_claim_bonus) {
                        if ($check_claim_bonus->is_claim_bonus == 6) {
                            return $this->errorResponse("Maaf, Bonus Deposit dapat diklaim sehari sekali.", 400);
                        }
                        if ($check_claim_bonus->is_claim_bonus == 4) {
                            return $this->errorResponse("Maaf, Bonus Deposit tidak dapat diklaim, Anda sudah mengklaim Bonus Freebet hari ini.", 400);
                        }
                    }
                    if ($request->jumlah < $bonus_deposit->min_depo) {
                        return $this->errorResponse("Maaf, Minimal deposit untuk klaim bonus deposit sebesar " . number_format($bonus_deposit->min_depo) . ".", 400);
                    }
                    if ($request->jumlah > $bonus_deposit->max_depo) {
                        return $this->errorResponse("Maaf, Maksimal deposit untuk klaim bonus deposit sebesar " . number_format($bonus_deposit->max_depo) . ".", 400);
                    }
                } else {
                    return $this->errorResponse("Bonus Deposit sedang tidak aktif.", 400);
                }
                $bonus = ($request->jumlah * $bonus_deposit->bonus_amount) / 100;
                $bonus_amount = $bonus_deposit->status_bonus == 1 ? $bonus : 0;
                $claimBonus = $bonus_deposit->status_bonus == 1 ? $request->is_claim_bonus : 0;
            }

            $active_rek = RekMemberModel::where([['created_by', $this->memberActive->id], ['is_depo', 1]])->first();
            $payload = [
                'rek_member_id' => $request->rekening_member_id,
                'members_id' => $this->memberActive->id,
                'rekening_id' => $request->rekening_id,
                'jumlah' => $request->jumlah,
                'credit' => MembersModel::where('id', $this->memberActive->id)->first()->credit,
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
            $rekening = RekeningModel::select(['constant_rekening_id'])->find($request->rekening_id);

            // WEB SOCKET START
            // ==================================================================
            CreateDepositEvent::dispatch($depositCreate);

            if ($rekening && $rekening->constant_rekening_id == 11) { // check if this is the destination for a DANA account
                BotDanaEvent::dispatch();
            }
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

            return $this->successResponse(null, 'Deposit berhasil');
        } catch (\Throwable$th) {
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

    public function settingBonusFreebet()
    {
        try {
            $userId = $this->memberActive->id;
            $dataSetting = BonusSettingModel::join('constant_bonus', 'constant_bonus.id', 'bonus_setting.constant_bonus_id')
                ->select(
                    'constant_bonus.nama_bonus',
                    'bonus_setting.min_depo',
                    'bonus_setting.max_depo',
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
                    ->whereBetween('approval_status_at', [$subDay, $today])->orderBy('approval_status_at', 'desc')->first();
                $dataBonusSetting[] = [
                    'id' => $item->id,
                    'name_bonus' => $item->nama_bonus,
                    'min_depo' => (float) $item->min_depo,
                    'max_depo' => (float) $item->max_depo,
                    'bonus_amount' => (int) $item->bonus_amount,
                    'turnover_x' => $item->turnover_x,
                    'turnover_amount' => (float) $item->turnover_amount,
                    'bonus_amount' => $checkKlaimBonus->bonus_amount ?? 0,
                    'info' => $item->info,
                    'status_bonus' => $item->status_bonus,
                    'durasi_bonus_promo' => $item->durasi_bonus_promo,
                    'is_claim_bonus' => $checkKlaimBonus ? 1 : 0,
                    'provider_id' => $item->constant_provider_id ? $providers : [],
                ];
            }
            return $this->successResponse($dataBonusSetting, 'Setting Bonus Freebet berhasil ditampilkan');
        } catch (\Throwable$th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }

    public function settingBonusDeposit()
    {
        try {
            $userId = $this->memberActive->id;
            $dataSetting = BonusSettingModel::join('constant_bonus', 'constant_bonus.id', 'bonus_setting.constant_bonus_id')
                ->select(
                    'constant_bonus.nama_bonus',
                    'bonus_setting.min_depo',
                    'bonus_setting.max_depo',
                    'bonus_setting.bonus_amount',
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
                $dataBonusSetting[] = [
                    'id' => $item->id,
                    'name_bonus' => $item->nama_bonus,
                    'min_depo' => (float) $item->min_depo,
                    'max_depo' => (float) $item->max_depo,
                    'bonus_amount' => (int) $item->bonus_amount,
                    'turnover_x' => $item->turnover_x,
                    'turnover_amount' => (float) $item->turnover_amount,
                    'bonus_amount' => $checkKlaimBonus->bonus_amount ?? 0,
                    'info' => $item->info,
                    'status_bonus' => $item->status_bonus,
                    'durasi_bonus_promo' => $item->durasi_bonus_promo,
                    'is_claim_bonus' => $checkKlaimBonus ? 1 : 0,
                    'provider_id' => $item->constant_provider_id ? $providers : [],
                ];
            }
            return $this->successResponse($dataBonusSetting, 'Setting Bonus Deposit berhasil ditampilkan');
        } catch (\Throwable$th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }

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
            $subDay = Carbon::now()->subDays($durasiBonus)->format('Y-m-d 00:00:00');
            $today = Carbon::now()->format('Y-m-d 23:59:59');
            $Check_deposit_claim_bonus_freebet = DepositModel::where('members_id', $this->memberActive->id)
                ->where('approval_status', 1)
                ->where('is_claim_bonus', 4)
                ->whereBetween('approval_status_at', [$subDay, $today])->orderBy('approval_status_at', 'desc')->first();
            if ($bonus_freebet->status_bonus == 1 && $Check_deposit_claim_bonus_freebet) {
                $providerId = explode(',', $bonus_freebet->constant_provider_id);
                if (!in_array(16, $providerId)) {
                    $TOSlotCasinoFish = BetModel::whereIn('type', ['Win', 'Lose', 'Bet', 'Settle'])
                        ->whereBetween('created_at', [$Check_deposit_claim_bonus_freebet->approval_status_at, now()])
                        ->where('created_by', $this->memberActive->id)
                        ->whereIn('constant_provider_id', $providerId)->sum('bet');

                    $TOMember = $TOSlotCasinoFish;
                } else {
                    $TOSlotCasinoFish = BetModel::whereIn('type', ['Win', 'Lose', 'Bet', 'Settle'])
                        ->whereBetween('created_at', [$Check_deposit_claim_bonus_freebet->approval_status_at, now()])
                        ->where('created_by', $this->memberActive->id)
                        ->where('game_info', 'slot')->sum('bet');
                    $TOTogel = BetsTogel::whereBetween('created_at', [$Check_deposit_claim_bonus_freebet->approval_status_at, now()])
                        ->where('created_by', $this->memberActive->id)->sum('pay_amount');

                    $TOMember = $TOSlotCasinoFish + $TOTogel;
                }

                $total_depo = $Check_deposit_claim_bonus_freebet->jumlah;
                $turnover_x = $bonus_freebet->turnover_x;
                $bonus_amount = $bonus_freebet->bonus_amount;
                $depoPlusBonus = $total_depo + (($total_depo * $bonus_amount) / 100);
                $TO = $depoPlusBonus * $turnover_x;
                if ($Check_deposit_claim_bonus_freebet->status_bonus == 2) {
                    $status = preg_match("/menyerah/i", $Check_deposit_claim_bonus_freebet->reason_bonus) ? 'Menyerah' : 'Gagal';
                    $date = $Check_deposit_claim_bonus_freebet->approval_status_at;
                    $dateClaim = Carbon::parse($date)->addDays($durasiBonus + 1)->format('Y-m-d 00:00:00');
                    $data = [
                        'turnover' => $TO,
                        'turnover_member' => $TOMember,
                        'durasi_bonus_promo' => $bonus_freebet->durasi_bonus_promo,
                        'status_bonus' => $bonus_freebet->status_bonus,
                        'is_claim_bonus' => $Check_deposit_claim_bonus_freebet->is_claim_bonus,
                        'bonus_amount' => $Check_deposit_claim_bonus_freebet->bonus_amount,
                        'status_bonus_member' => $status,
                        'date_claim_again' => $dateClaim,
                    ];
                } else {
                    $status = $Check_deposit_claim_bonus_freebet->status_bonus == 0 ? 'Klaim' : 'Selesai';
                    $date = $Check_deposit_claim_bonus_freebet->approval_status_at;
                    $dateClaim = Carbon::parse($date)->addDays($durasiBonus + 1)->format('Y-m-d 00:00:00');
                    $data = [
                        'turnover' => $TO,
                        'turnover_member' => $TOMember,
                        'durasi_bonus_promo' => $bonus_freebet->durasi_bonus_promo,
                        'status_bonus' => $bonus_freebet->status_bonus,
                        'is_claim_bonus' => $Check_deposit_claim_bonus_freebet->is_claim_bonus,
                        'bonus_amount' => $Check_deposit_claim_bonus_freebet->bonus_amount,
                        'status_bonus_member' => $status,
                        'date_claim_again' => $dateClaim,
                    ];
                }
            } else {
                $data = [
                    'turnover' => 0,
                    'turnover_member' => 0,
                    'durasi_bonus_promo' => 0,
                    'status_bonus' => 0,
                    'is_claim_bonus' => 0,
                    'bonus_amount' => 0,
                    'status_bonus_member' => null,
                    'date_claim_again' => null,
                ];
            }
            return $this->successResponse([$data], 'Datanya ada', 200);
        } catch (\Throwable$th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }

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
            $Check_deposit_claim_bonus_deposit = DepositModel::where('members_id', $this->memberActive->id)
                ->where('approval_status', 1)
                ->where('is_claim_bonus', 6)
                ->whereBetween('approval_status_at', [$subDay, $today])->orderBy('approval_status_at', 'desc')->first();
            if ($bonus_deposit->status_bonus == 1 && $Check_deposit_claim_bonus_deposit) {
                $providerId = explode(',', $bonus_deposit->constant_provider_id);
                if (!in_array(16, $providerId)) {
                    $TOSlotCasinoFish = BetModel::whereIn('type', ['Win', 'Lose', 'Bet', 'Settle'])
                        ->whereBetween('created_at', [$Check_deposit_claim_bonus_deposit->approval_status_at, now()])
                        ->where('created_by', $this->memberActive->id)
                        ->whereIn('constant_provider_id', $providerId)->sum('bet');

                    $TOMember = $TOSlotCasinoFish;
                } else {
                    $TOSlotCasinoFish = BetModel::whereIn('type', ['Win', 'Lose', 'Bet', 'Settle'])
                        ->whereBetween('created_at', [$Check_deposit_claim_bonus_deposit->approval_status_at, now()])
                        ->where('created_by', $this->memberActive->id)
                        ->where('game_info', 'slot')->sum('bet');
                    $TOTogel = BetsTogel::whereBetween('created_at', [$Check_deposit_claim_bonus_deposit->approval_status_at, now()])
                        ->where('created_by', $this->memberActive->id)->sum('pay_amount');

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
                if ($Check_deposit_claim_bonus_deposit->status_bonus == 2) {
                    $status = preg_match("/menyerah/i", $Check_deposit_claim_bonus_deposit->reason_bonus) ? 'Menyerah' : 'Gagal';
                    $date = $Check_deposit_claim_bonus_deposit->approval_status_at;
                    $dateClaim = Carbon::parse($date)->addDays($durasiBonus + 1)->format('Y-m-d 00:00:00');
                    $data = [
                        'turnover' => $TO,
                        'turnover_member' => $TOMember,
                        'durasi_bonus_promo' => $bonus_deposit->durasi_bonus_promo,
                        'status_bonus' => $bonus_deposit->status_bonus,
                        'is_claim_bonus' => $Check_deposit_claim_bonus_deposit->is_claim_bonus,
                        'bonus_amount' => $Check_deposit_claim_bonus_deposit->bonus_amount,
                        'status_bonus_member' => $status,
                        'date_claim_again' => $dateClaim,
                    ];
                } else {
                    $status = $Check_deposit_claim_bonus_deposit->status_bonus == 0 ? 'Klaim' : 'Selesai';
                    $date = $Check_deposit_claim_bonus_deposit->approval_status_at;
                    $dateClaim = Carbon::parse($date)->addDays($durasiBonus + 1)->format('Y-m-d 00:00:00');
                    $data = [
                        'turnover' => $TO,
                        'turnover_member' => $TOMember,
                        'durasi_bonus_promo' => $bonus_deposit->durasi_bonus_promo,
                        'status_bonus' => $bonus_deposit->status_bonus,
                        'is_claim_bonus' => $Check_deposit_claim_bonus_deposit->is_claim_bonus,
                        'bonus_amount' => $Check_deposit_claim_bonus_deposit->bonus_amount,
                        'status_bonus_member' => $status,
                        'date_claim_again' => $dateClaim,
                    ];
                }
            } else {
                $data = [
                    'turnover' => 0,
                    'turnover_member' => 0,
                    'durasi_bonus_promo' => 0,
                    'status_bonus' => 0,
                    'is_claim_bonus' => 0,
                    'bonus_amount' => 0,
                    'status_bonus_member' => null,
                    'date_claim_again' => null,
                ];
            }
            return $this->successResponse([$data], 'Datanya ada', 200);
        } catch (\Throwable$th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }

    public function BonusFreebetGivUp(Request $request)
    {
        try {
            $memberId = $this->memberActive->id;
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
            $subDay = Carbon::now()->subDays($durasiBonus)->format('Y-m-d 00:00:00');
            $today = Carbon::now()->format('Y-m-d 23:59:59');
            $Check_deposit_claim_bonus_freebet = DepositModel::where('members_id', $this->memberActive->id)
                ->where('approval_status', 1)
                ->where('is_claim_bonus', 4)
                ->where('status_bonus', 0)
                ->whereBetween('approval_status_at', [$subDay, $today])->orderBy('approval_status_at', 'desc')
                ->first();
            if ($bonus_freebet->status_bonus == 1 && $Check_deposit_claim_bonus_freebet) {
                $providerId = explode(',', $bonus_freebet->constant_provider_id);
                if (!in_array(16, $providerId)) {
                    $TOSlotCasinoFish = BetModel::whereIn('type', ['Win', 'Lose', 'Bet', 'Settle'])
                        ->whereBetween('created_at', [$Check_deposit_claim_bonus_freebet->approval_status_at, now()])
                        ->where('created_by', $this->memberActive->id)
                        ->whereIn('constant_provider_id', $providerId)->sum('bet');
                    $TOTogel = BetsTogel::whereBetween('created_at', [$Check_deposit_claim_bonus_freebet->approval_status_at, now()])
                        ->where('created_by', $this->memberActive->id)->sum('pay_amount');

                    $TOmember = $TOSlotCasinoFish + $TOTogel;
                } else {
                    $TOSlotCasinoFish = BetModel::whereIn('type', ['Win', 'Lose', 'Bet', 'Settle'])
                        ->whereBetween('created_at', [$Check_deposit_claim_bonus_freebet->approval_status_at, now()])
                        ->where('created_by', $this->memberActive->id)
                        ->where('game_info', 'slot')->sum('bet');
                    $TOTogel = BetsTogel::whereBetween('created_at', [$Check_deposit_claim_bonus_freebet->approval_status_at, now()])
                        ->where('created_by', $this->memberActive->id)->sum('pay_amount');

                    $TOmember = $TOSlotCasinoFish + $TOTogel;
                }

                $total_depo = $Check_deposit_claim_bonus_freebet->jumlah;
                $turnover_x = $bonus_freebet->turnover_x;
                $bonus_amount = $bonus_freebet->bonus_amount;
                $depoPlusBonus = $total_depo + (($total_depo * $bonus_amount) / 100);
                $TO = $depoPlusBonus * $turnover_x;

                if ($TOmember > $TO) {
                    return $this->errorResponse('Maaf, Anda tidak dapat menyerah, karena Anda telah mencapai TO (Turnover) Bonus Freebet, silahkan Withdraw sekarang', 400);
                }

                $bonus = $Check_deposit_claim_bonus_freebet->bonus_amount;
                $member = MembersModel::where('id', $memberId)->first();
                $credit = $member->credit - $bonus;

                MembersModel::where('id', $memberId)
                    ->update([
                        'credit' => $credit,
                        'updated_by' => $this->memberActive->id,
                        'updated_at' => Carbon::now(),
                    ]);

                DepositModel::where('id', $Check_deposit_claim_bonus_freebet->id)
                    ->update([
                        'status_bonus' => 2,
                        'reason_bonus' => 'anda menyerah untuk mencapai TO (Turn Over) sebesar Rp. ' . $TO,
                        'updated_by' => $this->memberActive->id,
                        'updated_at' => Carbon::now(),
                    ]);

                BonusHistoryModel::create([
                    'is_send' => 1,
                    'is_use' => 1,
                    'is_delete' => 0,
                    'constant_bonus_id' => 4,
                    'jumlah' => $bonus,
                    'credit' => MembersModel::where('id', $memberId)->first()->credit,
                    'member_id' => $this->memberActive->id,
                    'hadiah' => 'Anda menyerah untuk mencapai TO (Turn Over) sebesar Rp. ' . number_format($TO) . ',  bonus sebasar Rp. ' . number_format($bonus) . ' kami tarik kembali, dari balance anda.',
                    'type' => 'uang',
                    'created_by' => 0,
                    'created_at' => Carbon::now(),
                ]);

                MemoModel::create([
                    'member_id' => $this->memberActive->id,
                    'sender_id' => 0,
                    'send_type' => 'System',
                    'subject' => 'Bonus Freebet',
                    'is_reply' => 1,
                    'is_bonus' => 1,
                    'content' => 'Maaf Anda tidak memenuhi persyaratan mengklaim Bonus Freebet, Anda menyerah untuk mencapai TO (Turn Over) sebesar Rp. ' . number_format($TO) . ',  bonus sebasar Rp. ' . number_format($bonus) . ' kami tarik kembali, dari balance anda.',
                    'created_at' => Carbon::now(),
                ]);

                UserLogModel::logMemberActivity(
                    'Bonus FreeBet Giveup',
                    $member,
                    $Check_deposit_claim_bonus_freebet,
                    [
                        'target' => 'Bonus FreeBet',
                        'activity' => 'Bonus FreeBet Giveup',
                        'ip_member' => $this->memberActive->last_login_ip,
                    ],
                    $member->username . 'Deducted Bonus FreeBet amount from member balance  ' . number_format($Check_deposit_claim_bonus_freebet->bonus_freebet_amount)
                );

                return response()->json([
                    'status' => 'success',
                    'message' => 'Penyerahan bonus Freebet berhasil.',
                ]);
            }

            return $this->errorResponse("Maaf, Bonus Freebet sudah tidak aktif atau kadaluarsa.", 400);

        } catch (\Throwable$th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }

    public function BonusDepositGivUp(Request $request)
    {
        try {
            $memberId = $this->memberActive->id;
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
                ->whereBetween('approval_status_at', [$subDay, $today])->orderBy('approval_status_at', 'desc')
                ->first();
            if ($bonus_deposit->status_bonus == 1 && $Check_deposit_claim_bonus_deposit) {
                $providerId = explode(',', $bonus_deposit->constant_provider_id);
                if (!in_array(16, $providerId)) {
                    $TOSlotCasinoFish = BetModel::whereIn('type', ['Win', 'Lose', 'Bet', 'Settle'])
                        ->whereBetween('created_at', [$Check_deposit_claim_bonus_deposit->approval_status_at, now()])
                        ->where('created_by', $this->memberActive->id)
                        ->whereIn('constant_provider_id', $providerId)->sum('bet');
                    $TOTogel = BetsTogel::whereBetween('created_at', [$Check_deposit_claim_bonus_deposit->approval_status_at, now()])
                        ->where('created_by', $this->memberActive->id)->sum('pay_amount');

                    $TOmember = $TOSlotCasinoFish + $TOTogel;
                } else {
                    $TOSlotCasinoFish = BetModel::whereIn('type', ['Win', 'Lose', 'Bet', 'Settle'])
                        ->whereBetween('created_at', [$Check_deposit_claim_bonus_deposit->approval_status_at, now()])
                        ->where('created_by', $this->memberActive->id)
                        ->where('game_info', 'slot')->sum('bet');
                    $TOTogel = BetsTogel::whereBetween('created_at', [$Check_deposit_claim_bonus_deposit->approval_status_at, now()])
                        ->where('created_by', $this->memberActive->id)->sum('pay_amount');

                    $TOmember = $TOSlotCasinoFish + $TOTogel;
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

                if ($TOmember > $TO) {
                    return $this->errorResponse('Maaf, Anda tidak dapat menyerah, karena Anda telah mencapai TO (Turnover) Bonus Freebet, silahkan Withdraw sekarang', 400);
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

                BonusHistoryModel::create([
                    'is_send' => 1,
                    'is_use' => 1,
                    'is_delete' => 0,
                    'constant_bonus_id' => 6,
                    'jumlah' => $bonus,
                    'credit' => MembersModel::where('id', $memberId)->first()->credit,
                    'member_id' => $this->memberActive->id,
                    'hadiah' => 'Anda menyerah untuk mencapai TO (Turn Over) sebesar Rp. ' . number_format($TO) . ',  bonus sebasar Rp. ' . number_format($bonus) . ' kami tarik kembali, dari balance anda.',
                    'type' => 'uang',
                    'created_by' => 0,
                    'created_at' => Carbon::now(),
                ]);

                MemoModel::create([
                    'member_id' => $this->memberActive->id,
                    'sender_id' => 0,
                    'send_type' => 'System',
                    'subject' => 'Bonus Deposit',
                    'is_reply' => 1,
                    'is_bonus' => 1,
                    'content' => 'Maaf Anda tidak memenuhi persyaratan mengklaim Bonus Deposit, Anda menyerah untuk mencapai TO (Turn Over) sebesar Rp. ' . number_format($TO) . ',  bonus sebasar Rp. ' . number_format($bonus) . ' kami tarik kembali, dari balance anda.',
                    'created_at' => Carbon::now(),
                ]);

                UserLogModel::logMemberActivity(
                    'Bonus Deposit Giveup',
                    $member,
                    $Check_deposit_claim_bonus_deposit,
                    [
                        'target' => 'Bonus Deposit',
                        'activity' => 'Bonus Deposit Giveup',
                        'ip_member' => $this->memberActive->last_login_ip,
                    ],
                    $member->username . 'Deducted Bonus Deposit amount from member balance  ' . number_format($Check_deposit_claim_bonus_deposit->bonus_deposit_amount)
                );

                return response()->json([
                    'status' => 'success',
                    'message' => 'Penyerahan bonus Deposit berhasil.',
                ]);
            }

            return $this->errorResponse("Maaf, Bonus Deposit sudah tidak aktif atau kadaluarsa.", 400);

        } catch (\Throwable$th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }
}
