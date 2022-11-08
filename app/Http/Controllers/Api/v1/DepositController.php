<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Models\BetModel;
use App\Models\BetsTogel;
use App\Models\BonusFreebetModel;
use App\Models\BonusHistoryModel;
use App\Models\ConstantProvider;
use App\Models\DepositModel;
use App\Models\MembersModel;
use App\Models\MemoModel;
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

            $bonus_freebet = BonusFreebetModel::first();
            $durasiBonus = $bonus_freebet->durasi_bonus_promo;
            $subDay = Carbon::now()->subDays($durasiBonus)->format('Y-m-d 00:00:00');
            $today = Carbon::now()->format('Y-m-d 23:59:59');
            $check_claim_bonus = DepositModel::where('members_id', auth('api')->user()->id)
                ->where('approval_status', 1)
                ->where('is_bonus_freebet', 1)
                ->whereBetween('approval_status_at', [$subDay, $today])->orderBy('approval_status_at', 'desc')->first();
            if ($request->is_bonus_freebet == 1 && $bonus_freebet->status_bonus == 1) {
                if ($check_claim_bonus) {
                    return $this->errorResponse("Maaf, Bonus Freebet dapat diklaim sehari sekali.", 400);
                }
                if ($request->jumlah < $bonus_freebet->min_depo) {
                    return $this->errorResponse("Maaf, Minimal deposit untuk klaim bonus freebet sebesar " . number_format($bonus_freebet->min_depo) . ".", 400);
                }
                if ($request->jumlah > $bonus_freebet->max_depo) {
                    return $this->errorResponse("Maaf, Maksimal deposit untuk klaim bonus freebet sebesar " . number_format($bonus_freebet->max_depo) . ".", 400);
                }
            };
            $active_rek = RekMemberModel::where([['created_by', auth('api')->user()->id], ['is_depo', 1]])->first();
            $bonus = ($request->jumlah * $bonus_freebet->bonus_amount) / 100;
            $payload = [
                'rek_member_id' => $request->rekening_member_id,
                'members_id' => auth('api')->user()->id,
                'rekening_id' => $request->rekening_id,
                'jumlah' => $request->jumlah,
                'is_bonus_freebet' => $request->is_bonus_freebet ?? 0,
                'bonus_freebet_amount' => $request->is_bonus_freebet == 1 && $bonus_freebet->status_bonus == 1 ? $bonus : 0,
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

            $Check_deposit_claim_bonus_freebet = DepositModel::create($payload);

            // MembersModel::where('id', auth('api')->user()->id)
            //         ->update([
            //             'rekening_id_tujuan_depo' => $request->rekening_id,
            //         ]);

            $user = auth('api')->user();
            UserLogModel::logMemberActivity(
                'Deposit Created',
                $user,
                $Check_deposit_claim_bonus_freebet,
                [
                    'target' => 'Deposit',
                    'activity' => 'Create Deposit',
                    'ip_member' => auth('api')->user()->last_login_ip,
                ],
                $user->username . ' Created a Deposit with amount ' . number_format($Check_deposit_claim_bonus_freebet->jumlah)
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
                    'bonus_freebet_amount' => $checkKlaimBonus->bonus_freebet_amount ?? 0,
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
            $memberId = auth('api')->user()->id;
            $bonus_freebet = BonusFreebetModel::first();
            $durasiBonus = $bonus_freebet->durasi_bonus_promo;
            $subDay = Carbon::now()->subDays($durasiBonus)->format('Y-m-d 00:00:00');
            $today = Carbon::now()->format('Y-m-d 23:59:59');
            $Check_deposit_claim_bonus_freebet = DepositModel::where('members_id', auth('api')->user()->id)
                ->where('approval_status', 1)
                ->where('is_bonus_freebet', 1)
                ->where('status_bonus_freebet', 0)
                ->whereBetween('approval_status_at', [$subDay, $today])->orderBy('approval_status_at', 'desc')
                ->first();
            if ($bonus_freebet->status_bonus == 1 && $Check_deposit_claim_bonus_freebet) {
                $providerId = explode(',', $bonus_freebet->provider_id);
                if (!in_array(16, $providerId)) {
                    $TOSlotCasinoFish = BetModel::whereIn('type', ['Win', 'Lose', 'Bet', 'Settle'])
                        ->whereBetween('created_at', [$Check_deposit_claim_bonus_freebet->approval_status_at, now()])
                        ->where('created_by', auth('api')->user()->id)
                        ->whereIn('constant_provider_id', $providerId)->sum('bet');
                    $TOTogel = BetsTogel::whereBetween('created_at', [$Check_deposit_claim_bonus_freebet->approval_status_at, now()])
                        ->where('created_by', auth('api')->user()->id)->sum('pay_amount');

                    $TOmember = $TOSlotCasinoFish + $TOTogel;
                } else {
                    $TOSlotCasinoFish = BetModel::whereIn('type', ['Win', 'Lose', 'Bet', 'Settle'])
                        ->whereBetween('created_at', [$Check_deposit_claim_bonus_freebet->approval_status_at, now()])
                        ->where('created_by', auth('api')->user()->id)
                        ->where('game_info', 'slot')->sum('bet');
                    $TOTogel = BetsTogel::whereBetween('created_at', [$Check_deposit_claim_bonus_freebet->approval_status_at, now()])
                        ->where('created_by', auth('api')->user()->id)->sum('pay_amount');

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

                $bonus = $Check_deposit_claim_bonus_freebet->bonus_freebet_amount;
                $member = MembersModel::where('id', $memberId)->first();
                $credit = $member->credit - $bonus;

                MembersModel::where('id', $memberId)
                    ->update([
                        'credit' => $credit,
                        'updated_by' => auth('api')->user()->id,
                        'updated_at' => Carbon::now(),
                    ]);

                DepositModel::where('members_id', auth('api')->user()->id)
                    ->update([
                        'status_bonus_freebet' => 2,
                        'reason_bonus_freebet' => 'anda menyerah untuk mencapai TO (Turn Over) sebesar Rp. ' . $TO,
                        'updated_by' => auth('api')->user()->id,
                        'updated_at' => Carbon::now(),
                    ]);

                BonusHistoryModel::create([
                    'is_send' => 1,
                    'is_use' => 1,
                    'is_delete' => 0,
                    'constant_bonus_id' => 4,
                    'jumlah' => $bonus,
                    'credit' => MembersModel::where('id', $memberId)->first()->credit,
                    'member_id' => auth('api')->user()->id,
                    'hadiah' => 'Anda menyerah untuk mencapai TO (Turn Over) sebesar Rp. ' . number_format($TO) . ',  bonus sebasar Rp. ' . number_format($bonus) . ' kami tarik kembali, dari balance anda.',
                    'type' => 'uang',
                    'created_by' => 0,
                    'created_at' => Carbon::now(),
                ]);

                MemoModel::create([
                    'member_id' => auth('api')->user()->id,
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
                        'ip_member' => auth('api')->user()->last_login_ip,
                    ],
                    $member->username . 'Deducted Bonus FreeBet amount from member balance  ' . number_format($Check_deposit_claim_bonus_freebet->bonus_freebet_amount)
                );
                auth('api')->user()->update([
                    'last_login_ip' => $request->ip,
                ]);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Bonus Freebet giveup successfully.',
                ]);
            }

            return $this->errorResponse("Maaf, Bonus Freebet sudah tidak aktif atau kadaluarsa.", 400);

        } catch (\Throwable$th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }
}
