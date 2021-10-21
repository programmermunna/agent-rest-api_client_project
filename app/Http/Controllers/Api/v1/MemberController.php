<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Models\BetModel;
use App\Models\DepositModel;
use App\Models\ImageContent;
use App\Models\MembersModel;
use App\Models\MemoModel;
use App\Models\RekeningTujuanDepo;
use App\Models\RekMemberModel;
use App\Models\TurnoverModel;
use App\Models\RekeningModel;
use App\Models\UserLogModel;
use App\Models\WithdrawModel;
use App\Models\BonusHistoryModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;            # pagination pake ini
use Illuminate\Support\Facades\Validator;              # pagination pake ini
use Livewire\WithPagination; # pagination pake ini

class MemberController extends ApiController
{
    use WithPagination;
    protected $member;
    public $perPage = 20;
    public $perPageDepo = 10;
    public $perPageWd = 10;
    public $statement = [];
    public $bets = [];
    public $cek = [];
    public $rekMemberList = [];
    public $statementDepo = [];
    public $statementWd = [];
    public $groupBy;


    #Rest api history by type
    public $deposit = [];
    public $bonus = [];
    public $withdraw = [];
    public $pragmaticBet = [];
    public $habaneroBet = [];
    public $spadeBet = [];
    public $jokerBet = [];
    public $playtechBet = [];
    public $pgBet = [];
    public $pragmaticRef = [];
    public $habaneroRef = [];
    public $spadeRef = [];
    public $jokerRef = [];
    public $playtechRef = [];
    public $pgRef = [];
    public $allProviderBet = [];
    public $allProviderReferal = [];
    public $pageAll = 5;
	public $togel = [];





    // history by type
    public function historyAll(Request $request)
    {
        try {
            $deposit = DepositModel::join('members', 'members.id', '=', 'deposit.members_id')->select([
                    'members.credit',
                    'deposit.jumlah',
                    'deposit.approval_status',
                    'deposit.created_at',
                ])
                ->where('deposit.created_by', auth('api')->user()->id)
                ->where('approval_status', 1)
                ->orderBy('created_at', 'desc');

            $withdraw = WithdrawModel::join('members', 'members.id', '=', 'withdraw.members_id')->select([
                    'members.credit',
                    'withdraw.jumlah',
                    'withdraw.approval_status',
                    'withdraw.created_at',
                ])
                ->where('withdraw.created_by', auth('api')->user()->id)
                ->where('approval_status', 1)
                ->orderBy('created_at', 'desc');


            $query = BetModel::join('members', 'members.id', '=', 'bets.created_by')
                ->join('constant_provider', 'constant_provider.id', '=', 'bets.constant_provider_id');

            // $memo = MemoModel::join('members', 'members.id', '=', 'memo.member_id')
            //     ->where('memo.member_id', auth('api')->user()->id)->where('is_bonus', 1)
            //     ->select([
            //         'members.username',
            //         'memo.is_bonus',
            //         'memo.subject',
            //         'memo.content',
            //         'memo.created_at',
            //     ]);
            $bonus = BonusHistoryModel::join('constant_bonus', 'constant_bonus.id', '=', 'bonus_history.constant_bonus_id')
                ->where([
                    ['bonus_history.created_by', '=', auth('api')->user()->id],
                    ['bonus_history.jumlah', '>', 0]
                ])
                ->select([
                    'bonus_history.id',
                    'bonus_history.created_by',
                    'bonus_history.type',
                    'bonus_history.created_at',
                    'bonus_history.jumlah',
                    'bonus_history.hadiah',
                    'constant_bonus.nama_bonus',
                ]);


            if ($request->type == 'deposit') {
                $this->deposit = $deposit->get()->toArray();
                $depo = $this->paginate($this->deposit, $this->perPageDepo);

                $this->withdraw = $withdraw->get()->toArray();
                $wd = $this->paginate($this->withdraw, $this->perPageWd);

                return  $data = [
                    'status' => 'success',
                    'deposit' => $depo,
                    'withdraw' => $wd,
                ];
            } elseif ($request->type == 'pragmaticBet') {
                $pragmBet = $query->where('constant_provider.constant_provider_name', 'Pragmatic')
                    ->select(
                        'bets.bet',
                        'bets.game_info',
                        'bets.bet_id',
                        'bets.game_id',
                        'bets.deskripsi',
                        'bets.credit',
                        'bets.win',
                        'bets.type',
                        'bets.created_at',
                        'constant_provider.constant_provider_name'
                    )->where('bets.created_by', auth('api')->user()->id)
                    ->where('bets.constant_provider_id', 1)->get();

                $this->pragmaticBet = $pragmBet->toArray();
                $pragmaticBet = $this->paginate($this->pragmaticBet, $this->perPage);

                return $data = [
                    'status' => 'success',
                    'pragmaticBet' => $pragmaticBet,
                 ];
            } elseif ($request->type == 'habaneroBet') {
                $habaneBet = $query->where('constant_provider.constant_provider_name', 'Habanero')
                    ->select(
                        'bets.bet',
                        'bets.game_info',
                        'bets.bet_id',
                        'bets.game_id',
                        'bets.deskripsi',
                        'bets.credit',
                        'bets.win',
                        'bets.type',
                        'bets.created_at',
                        'constant_provider.constant_provider_name'
                    )->where('bets.created_by', auth('api')->user()->id)
                    ->where('bets.constant_provider_id', 2)->get();

                $this->habaneroBet = $habaneBet->toArray();
                $habaneroBet = $this->paginate($this->habaneroBet, $this->perPage);

                return $data = [
                    'status' => 'success',
                    'habaneroBet' => $habaneroBet,
                 ];
            } elseif ($request->type == 'spadeBet') {
                $spBet = $query->where('constant_provider.constant_provider_name', 'Spade Gaming')
                    ->select(
                        'bets.bet',
                        'bets.game_info',
                        'bets.bet_id',
                        'bets.game_id',
                        'bets.deskripsi',
                        'bets.credit',
                        'bets.win',
                        'bets.type',
                        'bets.created_at',
                        'constant_provider.constant_provider_name'
                    )->where('bets.created_by', auth('api')->user()->id)
                    ->where('bets.constant_provider_id', 4)->get();

                $this->spadeBet = $spBet->toArray();
                $spadeBet = $this->paginate($this->spadeBet, $this->perPage);

                return $data = [
                    'status' => 'success',
                    'spadeBet' => $spadeBet,
                ];
            } elseif ($request->type == 'jokerBet') {
                $jokBet = $query->where('constant_provider.constant_provider_name', 'Joker Gaming')
                    ->select(
                        'bets.bet',
                        'bets.game_info',
                        'bets.bet_id',
                        'bets.game_id',
                        'bets.deskripsi',
                        'bets.credit',
                        'bets.win',
                        'bets.type',
                        'bets.created_at',
                        'constant_provider.constant_provider_name'
                    )->where('bets.created_by', auth('api')->user()->id)
                    ->where('bets.constant_provider_id', 3)->get();

                $this->jokerBet = $jokBet->toArray();
                $jokerBet = $this->paginate($this->jokerBet, $this->perPage);

                return $data = [
                    'status' => 'success',
                    'jokerBet' => $jokerBet,
                ];
            } elseif ($request->type == 'playtechBet') {
                $playBet = $query->where('constant_provider.constant_provider_name', 'Playtech')
                    ->select(
                        'bets.bet',
                        'bets.game_info',
                        'bets.bet_id',
                        'bets.game_id',
                        'bets.deskripsi',
                        'bets.credit',
                        'bets.win',
                        'bets.type',
                        'bets.created_at',
                        'constant_provider.constant_provider_name'
                    )->where('bets.created_by', auth('api')->user()->id)
                    ->where('bets.constant_provider_id', 6)->get();

                $this->playtechBet = $playBet->toArray();
                $playtechBet = $this->paginate($this->playtechBet, $this->perPage);

                return $data = [
                    'status' => 'success',
                    'playtechBet' => $playtechBet,
                ];
            } elseif ($request->type == 'pgBet') {
                $pBet = $query->where('constant_provider.constant_provider_name', 'Pg Soft')
                    ->select(
                        'bets.bet',
                        'bets.game_info',
                        'bets.bet_id',
                        'bets.game_id',
                        'bets.deskripsi',
                        'bets.credit',
                        'bets.type',
                        'bets.win',
                        'bets.created_at',
                        'constant_provider.constant_provider_name'
                    )->where('bets.created_by', auth('api')->user()->id)
                    ->where('bets.constant_provider_id', 5)->get();

                $this->pgBet = $pBet->toArray();
                $pgBet = $this->paginate($this->pgBet, $this->perPage);

                return $data = [
                    'status' => 'success',
                    'pgBet' => $pgBet,
                ];
            } elseif ($request->type == 'pragmaticRef') {
                $pragmRef = $query->select(
                    'members.id',
                    'bets.game_info',
                    'bets.bet_id',
                    'bets.game_id',
                    'bets.deskripsi',
                    'bets.created_at',
                    'members.referrer_id',
                    'bets.bonus_daily_referal',
                    'members.username',
                    'bets.bonus_daily_referal',
                    'constant_provider.constant_provider_name'
                )->where('members.referrer_id', auth('api')->user()->id)
                    ->where('constant_provider.constant_provider_name', 'Pragmatic')->get();

                $this->pragmaticRef = $pragmRef->toArray();
                $pragmaticRef = $this->paginate($this->pragmaticRef, $this->perPage);

                return $data = [
                    'status' => 'success',
                    'pragmaticRef' => $pragmaticRef,
                ];
            } elseif ($request->type == 'habaneroRef') {
                $habanRef = $query->select(
                    'members.id',
                    'bets.game_info',
                    'bets.bet_id',
                    'bets.game_id',
                    'bets.deskripsi',
                    'bets.created_at',
                    'members.referrer_id',
                    'bets.bonus_daily_referal',
                    'members.username',
                    'bets.bonus_daily_referal',
                    'constant_provider.constant_provider_name'
                )->where('members.referrer_id', auth('api')->user()->id)
                    ->where('constant_provider.constant_provider_name', 'Habanero')->get();

                $this->habaneroRef = $habanRef->toArray();
                $habaneroRef = $this->paginate($this->habaneroRef, $this->perPage);

                return $data = [
                    'status' => 'success',
                    'habaneroRef' => $habaneroRef,
                ];
            } elseif ($request->type == 'spadeRef') {
                $spRef = $query->select(
                    'members.id',
                    'bets.game_info',
                    'bets.bet_id',
                    'bets.game_id',
                    'bets.deskripsi',
                    'bets.created_at',
                    'members.referrer_id',
                    'bets.bonus_daily_referal',
                    'members.username',
                    'bets.bonus_daily_referal',
                    'constant_provider.constant_provider_name'
                )->where('members.referrer_id', auth('api')->user()->id)
                    ->where('constant_provider.constant_provider_name', 'Spade Gaming')->get();

                $this->spadeRef = $spRef->toArray();
                $spadeRef = $this->paginate($this->spadeRef, $this->perPage);

                return $data = [
                    'status' => 'success',
                    'spadeRef' => $spadeRef,
                ];
            } elseif ($request->type == 'jokerRef') {
                $jokRef = $query->select(
                    'members.id',
                    'bets.game_info',
                    'bets.bet_id',
                    'bets.game_id',
                    'bets.deskripsi',
                    'bets.created_at',
                    'members.referrer_id',
                    'bets.bonus_daily_referal',
                    'members.username',
                    'bets.bonus_daily_referal',
                    'constant_provider.constant_provider_name'
                )->where('members.referrer_id', auth('api')->user()->id)
                    ->where('constant_provider.constant_provider_name', 'Joker Gaming')->get();

                $this->jokerRef = $jokRef->toArray();
                $jokerRef = $this->paginate($this->jokerRef, $this->perPage);

                return $data = [
                    'status' => 'success',
                    'jokerRef' => $jokerRef,
                ];
            } elseif ($request->type == 'playtechRef') {
                $playRef = $query->select(
                    'members.id',
                    'bets.game_info',
                    'bets.bet_id',
                    'bets.game_id',
                    'bets.deskripsi',
                    'bets.created_at',
                    'members.referrer_id',
                    'bets.bonus_daily_referal',
                    'members.username',
                    'bets.bonus_daily_referal',
                    'constant_provider.constant_provider_name'
                )->where('members.referrer_id', auth('api')->user()->id)
                    ->where('constant_provider.constant_provider_name', 'Playtech')->get();

                $this->playtechRef = $playRef->toArray();
                $playtechRef = $this->paginate($this->playtechRef, $this->perPage);

                return $data = [
                    'status' => 'success',
                    'playtechRef' => $playtechRef,
                ];
            } elseif ($request->type == 'pgRef') {
                $pRef = $query->select(
                    'members.id',
                    'bets.game_info',
                    'bets.bet_id',
                    'bets.game_id',
                    'bets.deskripsi',
                    'bets.created_at',
                    'members.referrer_id',
                    'bets.bonus_daily_referal',
                    'members.username',
                    'bets.bonus_daily_referal',
                    'constant_provider.constant_provider_name'
                )->where('members.referrer_id', auth('api')->user()->id)
                    ->where('constant_provider.constant_provider_name', 'Pg Soft')->get();

                $this->pgRef = $pRef->toArray();
                $pgRef = $this->paginate($this->pgRef, $this->perPage);

                return $data = [
                    'status' => 'success',
                    'pgRef' => $pgRef,
                ];
            } elseif ($request->type == 'dll') {
                $this->bonus = $bonus->get()->toArray();
                $bonusArr = $this->paginate($this->bonus, $this->perPage);

                return $data = [
                    'status' => 'success',
                    'dll' => $bonusArr,
                ];
			} else if ($request->type == 'togel') {
				return $this->getTogel($this->perPage);
			} else {
                $this->deposit = $deposit->get()->toArray();
                $depo = $this->paginate($this->deposit, $this->pageAll);

                $this->withdraw = $withdraw->get()->toArray();
                $wd = $this->paginate($this->withdraw, $this->pageAll);

                $allProReferal = $query->select(
                    'members.id',
                    'bets.game_info',
                    'bets.bet_id',
                    'bets.game_id',
                    'bets.deskripsi',
                    'bets.created_at',
                    'members.referrer_id',
                    'bets.bonus_daily_referal',
                    'members.username',
                    'bets.bonus_daily_referal',
                    'constant_provider.constant_provider_name'
                )->where('members.referrer_id', auth('api')->user()->id)->get();

                $this->allProviderReferal = $allProReferal->toArray();
                $allProviderReferal = $this->paginate($this->allProviderReferal, $this->pageAll);

                //all provider bet
                $allProBet = BetModel::join('members', 'members.id', '=', 'bets.created_by')
                    ->join('constant_provider', 'constant_provider.id', '=', 'bets.constant_provider_id')
                    ->select(
                        'bets.bet',
                        'bets.win',
                        'bets.game_info',
                        'bets.bet_id',
                        'bets.game_id',
                        'bets.deskripsi',
                        'bets.credit',
                        'constant_provider.constant_provider_name'
                    )->where('bets.created_by', auth('api')->user()->id)->get();

                $this->allProviderBet = $allProBet->toArray();
                $allProviderBet = $this->paginate($this->allProviderBet, $this->pageAll);

                $this->bonus = $bonus->get()->toArray();
                $bonusArr = $this->paginate($this->bonus, $this->pageAll);
				$togel = $this->paginate($this->togel , $this->perPage);
                return [
                    'deposit' => $depo,
                    'withdraw' => $wd,
                    'allProviderBet' => $allProviderBet,
                    'allProviderReferal' => $allProviderReferal,
                    'Bonus/Promo' => $bonusArr,
					'togel' => $this->getTogel($this->pageAll),
                ];
            }
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 500);
        }
    }

	public function getTogel(int $perPage)
	{
		$result = DB::select(DB::raw("
				select
					if (
						a.created_at is null
						, a.updated_at
						, a.created_at
					) as 'Tanggal'
					, a.pasaran as 'Pasaran'
					, c.name as 'Game'
					, b.id as 'Bet ID'
					, a.description as 'Deskripsi'
					, a.debit as 'Debit'
					, a.kredit as 'Kredit'
					, a.balance as 'Balance'
					from
						bets_togel_history_transaksi a
						join bets_togel b on a.created_by = b.created_by and a.created_at = b.created_at
						join togel_game c on b.togel_game_id = c.id
						group by b.id
			     "));
		$this->togel = $result;

		return $this->paginate($this->togel, $perPage);
	}	


    public function __construct()
    {
        $this->member = auth('api')->user();
    }

    // public function bank_account()
    // {
    //     try {
    //         $bank_account = MembersModel::leftJoin('constant_rekening as constRek', 'constRek.id', '=', 'members.constant_rekening_id')
    //         ->select([
    //             'constRek.name',
    //             'members.nomor_rekening',
    //             'members.nama_rekening',
    //         ])
    //         ->where('members.id', $this->member->id)
    //         ->first();

    //         if ($bank_account) {
    //             return $this->successResponse($bank_account->only(['name', 'nomor_rekening', 'nama_rekening']));
    //         }

    //         return $this->successResponse(null, 'No content', 204);
    //     } catch (\Throwable $th) {
    //         return $this->errorResponse('Internal Server Error', 500);
    //     }
    // }

    public function winLoseStatus()
    {
        try {
            return $this->successResponse(null, 'No content', 204);
        } catch (\Throwable $th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }

    public function depostiWithdrawStatus()
    {
        try {
            #member
            // $deposit = DepositModel::leftJoin('members', 'members.id', 'deposit.members_id')
            //     ->leftJoin('constant_rekening as constRek', 'constRek.id', '=', 'members.constant_rekening_id')
            $deposit = DepositModel::leftJoin('rek_member', 'rek_member.id', 'deposit.rek_member_id')
                ->leftJoin('constant_rekening as constRek', 'constRek.id', '=', 'rek_member.constant_rekening_id')
                ->select([
                    'deposit.jumlah',
                    'deposit.approval_status',
                    'deposit.created_at',
                    'constRek.name AS bankNameMember',
                ])
                ->where('members_id', $this->member->id)->latest()->first();

            #member
            // $withdraw = WithdrawModel::leftJoin('members', 'members.id', 'withdraw.members_id')
            // ->leftJoin('constant_rekening as constRek', 'constRek.id', '=', 'members.constant_rekening_id')
            $withdraw = WithdrawModel::leftJoin('rek_member', 'rek_member.id', 'withdraw.rek_member_id')
                ->leftJoin('constant_rekening as constRek', 'constRek.id', '=', 'rek_member.constant_rekening_id')
                ->select([
                    'withdraw.jumlah',
                    'withdraw.created_at',
                    'withdraw.approval_status',
                    'constRek.name AS bankNameMember',
                ])
                ->where('members_id', $this->member->id)->latest()->first();

            $response = [
                'deposit' => null,
                'withdraw' => null,
            ];
            if ($deposit || $withdraw) {
                if ($deposit) {
                    $response['deposit'] = [
                        'amount' => $deposit->jumlah,
                        'status' => $deposit->approval_status,
                        'created_at' => $deposit->created_at,
                        'bank_member' => $deposit->bankNameMember,
                    ];
                }

                if ($withdraw) {
                    $response['withdraw'] = [
                        'amount' => $withdraw->jumlah,
                        'status' => $withdraw->approval_status,
                        'created_at' => $withdraw->created_at,
                        'agent_bank' => $withdraw->bankNameMember,
                    ];
                }

                // create bonus turnover member
                // $bets = BetModel::join('members', 'members.id', 'bets.created_by')
                //     ->where('created_by', auth('api')->user()->id)
                //     ->select(
                //         'bets.created_by',
                //         DB::raw("(sum(bets.bet)) as Bet_Lose"),
                //         DB::raw("(sum(bets.win)) as Win"),
                //         DB::raw("(sum(bets.win)) + (sum(bets.bet)) as Balance"),
                //     )
                //     ->where('bets.created_by', auth('api')->user()->id)
                //     ->groupBy('bets.created_by')->first();
                // $enableTurnover = ImageContent::where('type', 'turnover')->where('enabled', 1)->select('enabled')->first();
                // $turnover = TurnoverModel::where('created_by', auth('api')->user()->id)->first();
                // $creditMember = MembersModel::where('id', auth('api')->user()->id)->first();
                // if (! empty($bets) && $enableTurnover != null) {
                //     if ($bets->Balance >= 50000000 && $bets->Balance <= 99999999 && $turnover->is_turnover1 == 0 && $enableTurnover->enabled == 1) {
                //         $creditMember->update([
                //             'credit' => $creditMember->credit + 50000,
                //         ]);
                //         $turnover->update([
                //             'is_turnover1' => 1,
                //         ]);
                //         $createMemo = MemoModel::create([
                //             'member_id' => auth('api')->user()->id,
                //             'sender_id' => 1,
                //             'subject' => 'Bonus turnover',
                //             'is_reply' => 1,
                //             'is_bonus' => 1,
                //             'content' => 'Selamat Anda Mendapatkan Bonus Turnover Sebesar Rp 50.000',
                //             'created_at' => Carbon::now(),
                //         ]);
                //     } elseif ($bets->Balance >= 100000000 && $bets->Balance <= 199999999 && $turnover->is_turnover2 == 0 && $enableTurnover->enabled == 1) {
                //         $creditMember->update([
                //             'credit' => $creditMember->credit + 100000,
                //         ]);
                //         $turnover->update([
                //             'is_turnover2' => 1,
                //         ]);
                //         // $saldoSebelumTurnover = $creditMember->credit - 100000;
                //         $createMemo = MemoModel::create([
                //             'member_id' => auth('api')->user()->id,
                //             'sender_id' => 1,
                //             'subject' => 'Bonus turnover',
                //             'is_reply' => 1,
                //             'is_bonus' => 1,
                //             'content' => 'Selamat Anda Mendapatkan Bonus Turnover Sebesar Rp 100.000',
                //             'created_at' => Carbon::now(),
                //         ]);
                //     } elseif ($bets->Balance >= 200000000 && $bets->Balance <= 299999999 && $turnover->is_turnover3 == 0 && $enableTurnover->enabled == 1) {
                //         $creditMember->update([
                //             'credit' => $creditMember->credit + 200000,
                //         ]);
                //         $turnover->update([
                //             'is_turnover3' => 1,
                //         ]);
                //         $createMemo = MemoModel::create([
                //             'member_id' => auth('api')->user()->id,
                //             'sender_id' => 1,
                //             'subject' => 'Bonus turnover',
                //             'is_reply' => 1,
                //             'is_bonus' => 1,
                //             'content' => 'Selamat Anda Mendapatkan Bonus Turnover Sebesar Rp 200.000',
                //             'created_at' => Carbon::now(),
                //         ]);
                //     } elseif ($bets->Balance >= 300000000 && $bets->Balance <= 499999999 && $turnover->is_turnover4 == 0 && $enableTurnover->enabled == 1) {
                //         $creditMember->update([
                //             'credit' => $creditMember->credit + 300000,
                //         ]);
                //         $turnover->update([
                //             'is_turnover4' => 1,
                //         ]);
                //         $createMemo = MemoModel::create([
                //             'member_id' => auth('api')->user()->id,
                //             'sender_id' => 1,
                //             'subject' => 'Bonus turnover',
                //             'is_reply' => 1,
                //             'is_bonus' => 1,
                //             'content' => 'Selamat Anda Mendapatkan Bonus Turnover Sebesar Rp 300.000',
                //             'created_at' => Carbon::now(),
                //         ]);
                //     } elseif ($bets->Balance >= 500000000 && $bets->Balance <= 999999999 && $turnover->is_turnover5 == 0 && $enableTurnover->enabled == 1) {
                //         $creditMember->update([
                //             'credit' => $creditMember->credit + 600000,
                //         ]);
                //         $turnover->update([
                //             'is_turnover5' => 1,
                //         ]);
                //         $createMemo = MemoModel::create([
                //             'member_id' => auth('api')->user()->id,
                //             'sender_id' => 1,
                //             'subject' => 'Bonus turnover',
                //             'is_reply' => 1,
                //             'is_bonus' => 1,
                //             'content' => 'Selamat Anda Mendapatkan Bonus Turnover Sebesar Rp 600.000',
                //             'created_at' => Carbon::now(),
                //         ]);
                //     } elseif ($bets->Balance >= 1000000000 && $bets->Balance <= 1999999999 && $turnover->is_turnover6 == 0 && $enableTurnover->enabled == 1) {
                //         $creditMember->update([
                //             'credit' => $creditMember->credit + 1500000,
                //         ]);
                //         $turnover->update([
                //             'is_turnover6' => 1,
                //         ]);
                //         $createMemo = MemoModel::create([
                //             'member_id' => auth('api')->user()->id,
                //             'sender_id' => 1,
                //             'subject' => 'Bonus turnover',
                //             'is_reply' => 1,
                //             'is_bonus' => 1,
                //             'content' => 'Selamat Anda Mendapatkan Bonus Turnover Sebesar Rp 1.500.000',
                //             'created_at' => Carbon::now(),
                //         ]);
                //     } elseif ($bets->Balance >= 2000000000 && $bets->Balance <= 4999999999 && $turnover->is_turnover7 == 0 && $enableTurnover->enabled == 1) {
                //         $creditMember->update([
                //             'credit' => $creditMember->credit + 3000000,
                //         ]);
                //         $turnover->update([
                //             'is_turnover7' => 1,
                //         ]);
                //         $createMemo = MemoModel::create([
                //             'member_id' => auth('api')->user()->id,
                //             'sender_id' => 1,
                //             'subject' => 'Bonus turnover',
                //             'is_reply' => 1,
                //             'is_bonus' => 1,
                //             'content' => 'Selamat Anda Mendapatkan Bonus Turnover Sebesar Rp 3.000.000',
                //             'created_at' => Carbon::now(),
                //         ]);
                //     } elseif ($bets->Balance >= 5000000000 && $bets->Balance <= 9999999999 && $turnover->is_turnover8 == 0 && $enableTurnover->enabled == 1) {
                //         $createMemo = MemoModel::create([
                //             'member_id' => auth('api')->user()->id,
                //             'sender_id' => 1,
                //             'subject' => 'Bonus turnover',
                //             'is_reply' => 1,
                //             'is_bonus' => 1,
                //             'content' => 'Selamat Anda Mendapatkan Hp Samsung S21+ Ultra 128gb, Silahkan hubungi cs kami',
                //             'created_at' => Carbon::now(),
                //         ]);
                //         $turnover->update([
                //             'is_turnover8' => 1,
                //         ]);
                //     } elseif ($bets->Balance >= 10000000000 && $bets->Balance <= 24999999999 && $turnover->is_turnover9 == 0 && $enableTurnover->enabled == 1) {
                //         $createMemo = MemoModel::create([
                //             'member_id' => auth('api')->user()->id,
                //             'sender_id' => 1,
                //             'subject' => 'Bonus turnover',
                //             'is_reply' => 1,
                //             'is_bonus' => 1,
                //             'content' => 'Selamat Anda Mendapatkan Hp Iphone 12 Pro Max 256GB, Silahkan hubungi cs kami',
                //             'created_at' => Carbon::now(),
                //         ]);
                //         $turnover->update([
                //             'is_turnover9' => 1,
                //         ]);
                //     } elseif ($bets->Balance >= 25000000000 && $bets->Balance <= 49999999999 && $turnover->is_turnover10 == 0 && $enableTurnover->enabled == 1) {
                //         $createMemo = MemoModel::create([
                //             'member_id' => auth('api')->user()->id,
                //             'sender_id' => 1,
                //             'subject' => 'Bonus turnover',
                //             'is_reply' => 1,
                //             'is_bonus' => 1,
                //             'content' => 'Selamat Anda Mendapatkan Yamaha XMAX 250, Silahkan hubungi cs kami',
                //             'created_at' => Carbon::now(),
                //         ]);
                //         $turnover->update([
                //             'is_turnover10' => 1,
                //         ]);
                //     } elseif ($bets->Balance >= 50000000000 && $bets->Balance <= 99999999999 && $turnover->is_turnover11 == 0 && $enableTurnover->enabled == 1) {
                //         $createMemo = MemoModel::create([
                //             'member_id' => auth('api')->user()->id,
                //             'sender_id' => 1,
                //             'subject' => 'Bonus turnover',
                //             'is_reply' => 1,
                //             'is_bonus' => 1,
                //             'content' => 'Selamat Anda Mendapatkan Kawasaki Z126 PRO 2021, Silahkan hubungi cs kami',
                //             'created_at' => Carbon::now(),
                //         ]);
                //         $turnover->update([
                //             'is_turnover11' => 1,
                //         ]);
                //     } elseif ($bets->Balance >= 100000000000 && $bets->Balance <= 999999999999 && $turnover->is_turnover12 == 0 && $enableTurnover->enabled == 1) {
                //         $createMemo = MemoModel::create([
                //             'member_id' => auth('api')->user()->id,
                //             'sender_id' => 1,
                //             'subject' => 'Bonus turnover',
                //             'is_reply' => 1,
                //             'is_bonus' => 1,
                //             'content' => 'Selamat Anda Mendapatkan Honda Accord 2021, Silahkan hubungi cs kami',
                //             'created_at' => Carbon::now(),
                //         ]);
                //         $turnover->update([
                //             'is_turnover12' => 1,
                //         ]);
                //     } elseif ($bets->Balance >= 1000000000000 && $turnover->is_turnover13 == 0) {
                //         $createMemo = MemoModel::create([
                //             'member_id' => auth('api')->user()->id,
                //             'sender_id' => 1,
                //             'subject' => 'Bonus turnover',
                //             'is_reply' => 1,
                //             'is_bonus' => 1,
                //             'content' => 'Selamat Anda Mendapatkan Mercedes Benz GL-400, Silahkan hubungi cs kami',
                //             'created_at' => Carbon::now(),
                //         ]);
                //         $turnover->update([
                //             'is_turnover13' => 1,
                //         ]);
                //     }
                // }

                return $this->successResponse($response);
            } else {
                return $this->successResponse(null, 'No content', 204);
            }
        } catch (\Throwable $th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }

    public function getStatement()
    {
        try {
            $date = Carbon::now()->subDays(7);
            $date->format('Y-m-d');
            $statement = BetModel::join('members', 'members.id', '=', 'bets.created_by')
                ->select(
                    'bets.created_by',
                    'bets.created_at',
                    DB::raw("(sum(bets.bet)) as Bet_Lose"),
                    DB::raw("(sum(bets.win)) as Win"),
                    DB::raw("(sum(bets.win)) - (sum(bets.bet)) as Balance"),
                )
                ->where('bets.created_by', auth('api')->user()->id)
                ->where('bets.created_at', '>=', $date)
                ->orderBy('bets.created_at', 'desc')
                ->groupBy(DB::raw("DATE_FORMAT(bets.created_at, '%Y-%m-%d')"))
                ->groupBy('bets.created_by');
            $this->statement = $statement->get()->toArray();
            $arrStatement = $this->paginate($this->statement, $this->perPage);
            if ($arrStatement != null) {
                return $this->successResponse($arrStatement);
            } else {
                return $this->successResponse('No statement', 204);
            }
        } catch (\Throwable $th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }
    public function statementWdDepo()
    {
        try {
            $date = Carbon::now()->subDays(7);
            $date->format('Y-m-d');

            $deposit = DepositModel::select([
                    'jumlah',
                    'approval_status',
                    'created_at',
                ])
                ->where('created_by', auth('api')->user()->id)
                ->where('approval_status', 1)
                ->where('created_at', '>=', $date)
                ->orderBy('created_at', 'desc');
            $this->statementDepo = $deposit->get()->toArray();
            $arrStatementDepo = $this->paginate($this->statementDepo, $this->perPageDepo);

            $withdraw = WithdrawModel::select([
                    'jumlah',
                    'approval_status',
                    'created_at',
                ])
                ->where('created_by', auth('api')->user()->id)
                ->where('approval_status', 1)
                ->where('created_at', '>=', $date);
            $this->statementWd = $withdraw->get()->toArray();
            $arrStatementWd = $this->paginate($this->statementWd, $this->perPageWd);

            $response = [
                'deposit' => $arrStatementDepo,
                'withdraw' => $arrStatementWd,
            ];

            return $this->successResponse($response);
        } catch (\Throwable $th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }
    public function createRekeningMember(Request $request)
    {
        // dd(auth('api')->user()->id);
        $validator = Validator::make($request->all(), [
            'constant_rekening_id' => 'required',
            'nomor_rekening' => 'required|unique:rek_member',
            'account_name' => 'required',
        ]);
        // dd($validator);

        if ($validator->fails()) {
            return $this->errorResponse('Validation Error', 422, $validator->errors()->first());
        }

        try {
            $rekMember = RekMemberModel::join('constant_rekening', 'constant_rekening.id', 'rek_member.constant_rekening_id')
            ->select([
                'rek_member.id',
                'rek_member.nama_rekening',
                'rek_member.is_wd',
                'rek_member.is_default',
                'rek_member.constant_rekening_id',
                'rek_member.nomor_rekening',
                'constant_rekening.name',
            ])
            ->where('rek_member.created_by', auth('api')->user()->id)
            ->where('rek_member.constant_rekening_id', $request->constant_rekening_id);
            $this->rekMemberList = $rekMember->get()->toArray();
            if ($this->rekMemberList) {
                return $this->errorResponse('Rekening bank sudah dipakai', 400);
            } else {
                // MemoModel::insert($create);
                $createRekMember = RekMemberModel::create([
                    'username_member' => auth('api')->user()->username,
                    'created_by' => auth('api')->user()->id,
                    'constant_rekening_id' => $request->constant_rekening_id,
                    'nomor_rekening' => $request->nomor_rekening,
                    'nama_rekening' => $request->account_name,
                    'created_at' => Carbon::now(),
                ]);
                $user = auth('api')->user();
                UserLogModel::logMemberActivity(
                    'Created New Rekening',
                    $user,
                    $createRekMember,
                    [
                        'target' => $createRekMember->nomor_rekening,
                        'activity' => 'Created',
                    ],
                    "{$user->name} Created a Rekening nama_rekening: $createRekMember->nama_rekening. nomor_rekening: $createRekMember->nomor_rekening"
                );
                auth('api')->user()->update([
                    'last_login_ip' => $request->ip,
                ]);

                return $this->successResponse(null, 'Successful create New Rekening ', 200);
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }
    public function updateRekeningMemberWd(Request $request)
    {
        try {
            $logBeforUpdate = RekMemberModel::join('constant_rekening', 'constant_rekening.id', 'rek_member.constant_rekening_id')
                ->where('username_member', auth('api')->user()->username)
                ->where('is_wd', 1)
                ->where('is_default', 1)->first();
            $log = RekMemberModel::join('constant_rekening', 'constant_rekening.id', 'rek_member.constant_rekening_id')
                ->where('rek_member.id', $request->id)->first();
            
            $user = auth('api')->user();
            UserLogModel::logMemberActivity(
                'Updated is wd',
                $user,
                $log,
                [
                    'target' => 'Rekening',
                    'activity' => 'Updated',
                ],
                "Successfully update rekening: $logBeforUpdate->name $logBeforUpdate->nama_rekening  $logBeforUpdate->nomor_rekening -> $log->name $log->nama_rekening $log->nomor_rekening"
            );

            $data = RekMemberModel::where('username_member', auth('api')->user()->username)
                ->where('is_wd', 1)
                ->where('is_default', 1)->first();
            $data->update([
                'is_wd' => 0,
                'is_default' => 0,
            ]);
            auth('api')->user()->update([
                'last_login_ip' => $request->ip,
            ]);
            $UpdateRek = RekMemberModel::where('rek_member.id', $request->id)->first();
            $UpdateRek->update([
                    'is_wd' => 1,
                    'is_default' => 1,
                ]);


            return $this->successResponse(null, 'Successful update Rekening withdraw', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }
    // list rekening member
    public function listRekMember()
    {
        try {
            $rekMember = RekMemberModel::join('constant_rekening', 'constant_rekening.id', 'rek_member.constant_rekening_id')
            ->select([
                'rek_member.id',
                'rek_member.nama_rekening',
                'rek_member.is_wd',
                'rek_member.is_depo',
                'rek_member.is_default',
                'rek_member.nomor_rekening',
                'constant_rekening.name',
            ])
            ->where('username_member', auth('api')->user()->username)
            ->get();

            return $this->successResponse($rekMember, 'List Rekening ', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }
    // New list rekening member
    public function listRekAgent()
    {
        try {
            $rekTujuan = RekeningTujuanDepo::where('created_by', auth('api')->user()->id)->first();
            $bcaAgent = RekeningModel::join('constant_rekening', 'constant_rekening.id', 'rekening.constant_rekening_id')
                ->select([
                    'rekening.id',
                    'rekening.nama_rekening',
                    'rekening.nomor_rekening',
                    'constant_rekening.name',
                ])
                ->where('rekening.id', $rekTujuan->rekening_id_tujuan_depo1)->first();
            $mandiriAgent = RekeningModel::join('constant_rekening', 'constant_rekening.id', 'rekening.constant_rekening_id')
                ->select([
                    'rekening.id',
                    'rekening.nama_rekening',
                    'rekening.nomor_rekening',
                    'constant_rekening.name',
                ])
                ->where('rekening.id', $rekTujuan->rekening_id_tujuan_depo2)->first();
            $bniAgent = RekeningModel::join('constant_rekening', 'constant_rekening.id', 'rekening.constant_rekening_id')
                ->select([
                    'rekening.id',
                    'rekening.nama_rekening',
                    'rekening.nomor_rekening',
                    'constant_rekening.name',
                ])
                ->where('rekening.id', $rekTujuan->rekening_id_tujuan_depo3)->first();
            $briAgent = RekeningModel::join('constant_rekening', 'constant_rekening.id', 'rekening.constant_rekening_id')
                ->select([
                    'rekening.id',
                    'rekening.nama_rekening',
                    'rekening.nomor_rekening',
                    'constant_rekening.name',
                ])
                ->where('rekening.id', $rekTujuan->rekening_id_tujuan_depo4)->first();
            $cimbAgent = RekeningModel::join('constant_rekening', 'constant_rekening.id', 'rekening.constant_rekening_id')
                ->select([
                    'rekening.id',
                    'rekening.nama_rekening',
                    'rekening.nomor_rekening',
                    'constant_rekening.name',
                ])
                ->where('rekening.id', $rekTujuan->rekening_id_tujuan_depo5)->first();
            $danamondAgent = RekeningModel::join('constant_rekening', 'constant_rekening.id', 'rekening.constant_rekening_id')
                ->select([
                    'rekening.id',
                    'rekening.nama_rekening',
                    'rekening.nomor_rekening',
                    'constant_rekening.name',
                ])
                ->where('rekening.id', $rekTujuan->rekening_id_tujuan_depo6)->first();
            $telkomselAgent = RekeningModel::join('constant_rekening', 'constant_rekening.id', 'rekening.constant_rekening_id')
                ->select([
                    'rekening.id',
                    'rekening.nama_rekening',
                    'rekening.nomor_rekening',
                    'constant_rekening.name',
                ])
                ->where('rekening.id', $rekTujuan->rekening_id_tujuan_depo7)->first();
            $axiataAgent = RekeningModel::join('constant_rekening', 'constant_rekening.id', 'rekening.constant_rekening_id')
                ->select([
                    'rekening.id',
                    'rekening.nama_rekening',
                    'rekening.nomor_rekening',
                    'constant_rekening.name',
                ])
                ->where('rekening.id', $rekTujuan->rekening_id_tujuan_depo8)->first();
            $ovoAgent = RekeningModel::join('constant_rekening', 'constant_rekening.id', 'rekening.constant_rekening_id')
                ->select([
                    'rekening.id',
                    'rekening.nama_rekening',
                    'rekening.nomor_rekening',
                    'constant_rekening.name',
                ])
                ->where('rekening.id', $rekTujuan->rekening_id_tujuan_depo9)->first();
            $gopayAgent = RekeningModel::join('constant_rekening', 'constant_rekening.id', 'rekening.constant_rekening_id')
                ->select([
                    'rekening.id',
                    'rekening.nama_rekening',
                    'rekening.nomor_rekening',
                    'constant_rekening.name',
                ])
                ->where('rekening.id', $rekTujuan->rekening_id_tujuan_depo10)->first();
            $danaAgent = RekeningModel::join('constant_rekening', 'constant_rekening.id', 'rekening.constant_rekening_id')
                ->select([
                    'rekening.id',
                    'rekening.nama_rekening',
                    'rekening.nomor_rekening',
                    'constant_rekening.name',
                ])
                ->where('rekening.id', $rekTujuan->rekening_id_tujuan_depo11)->first();
            $linkAjaAgent = RekeningModel::join('constant_rekening', 'constant_rekening.id', 'rekening.constant_rekening_id')
                ->select([
                    'rekening.id',
                    'rekening.nama_rekening',
                    'rekening.nomor_rekening',
                    'constant_rekening.name',
                ])
                ->where('rekening.id', $rekTujuan->rekening_id_tujuan_depo12)->first();
            $bankName = ['bca', 'mandiri', 'bni', 'bri', 'cimb', 'danamond', 'telkomsel', 'axiata', 'ovo', 'gopay', 'dana', 'linkAja'];
            $listRek = [];

            for ($i=0; $i < count($bankName); $i++) { 
                array_push($listRek, ${$bankName[$i]."Agent"});
            }
            return $this->successResponse($listRek, 'List Rekening Agent', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }
    // rek member wd
    public function rekMemberWd()
    {
        try {
            $rekMember = RekMemberModel::join('constant_rekening', 'constant_rekening.id', 'rek_member.constant_rekening_id')
            ->select([
                'rek_member.nama_rekening',
                'rek_member.nomor_rekening',
                'constant_rekening.name',
                'constant_rekening.id As constant_rekening_id',
            ])
            ->where('rek_member.created_by', auth('api')->user()->id)
            ->where('is_wd', 1)
            ->get();

            return $this->successResponse($rekMember, 'List Rekening ', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }

    public function bonusTurnover(Request $request)
    {
        $enableTurnover = ImageContent::where('type', 'turnover')->where('enabled', 1)->select('enabled')->first();
        // create bonus turnover member
        $bets = BetModel::join('members', 'members.id', 'bets.created_by')
            ->where('created_by', auth('api')->user()->id)
            ->select(
                'bets.created_by',
                DB::raw("(sum(bets.bet)) as Bet_Lose"),
                DB::raw("(sum(bets.win)) as Win"),
                DB::raw("(sum(bets.win)) + (sum(bets.bet)) as Balance"),
            )
            ->where('bets.created_by', auth('api')->user()->id)
            ->groupBy('bets.created_by')->first();
        // dd($bets);
        if (is_null($bets) || $enableTurnover == null) {
            return $this->successResponse(null, 'Tidak ada bonus turnover yang di peroleh', 200);
        } else {
            $turnover = TurnoverModel::where('created_by', auth('api')->user()->id)->first();
            $creditMember = MembersModel::where('id', auth('api')->user()->id)->first();
            if ($bets->Balance >= 50000000 && $bets->Balance <= 99999999 && $turnover->is_turnover1 == 0 && $enableTurnover->enabled == 1) {
                $creditMember->update([
                    'credit' => $creditMember->credit + 50000,
                ]);
                $turnover->update([
                    'is_turnover1' => 1,
                ]);
                $createMemo = MemoModel::create([
                    'member_id' => auth('api')->user()->id,
                    'sender_id' => 1,
                    'subject' => 'Bonus turnover',
                    'is_reply' => 1,
                    'is_bonus' => 1,
                    'content' => 'Selamat Anda Mendapatkan Bonus Turnover Sebesar Rp 50.000',
                    'created_at' => Carbon::now(),
                ]);

                return $this->successResponse(null, 'Selamat anda mendapatkan bonus turnover sebesar Rp 50.000', 200);
            } elseif ($bets->Balance >= 100000000 && $bets->Balance <= 199999999 && $turnover->is_turnover2 == 0 && $enableTurnover->enabled == 1) {
                $creditMember->update([
                    'credit' => $creditMember->credit + 100000,
                ]);
                $turnover->update([
                    'is_turnover2' => 1,
                ]);
                // $saldoSebelumTurnover = $creditMember->credit - 100000;
                $createMemo = MemoModel::create([
                    'member_id' => auth('api')->user()->id,
                    'sender_id' => 1,
                    'subject' => 'Bonus turnover',
                    'is_reply' => 1,
                    'is_bonus' => 1,
                    'content' => 'Selamat Anda Mendapatkan Bonus Turnover Sebesar Rp 100.000',
                    'created_at' => Carbon::now(),
                ]);

                return $this->successResponse(null, 'Selamat anda mendapatkan bonus turnover sebesar Rp 100.000', 200);
            } elseif ($bets->Balance >= 200000000 && $bets->Balance <= 299999999 && $turnover->is_turnover3 == 0 && $enableTurnover->enabled == 1) {
                $creditMember->update([
                    'credit' => $creditMember->credit + 200000,
                ]);
                $turnover->update([
                    'is_turnover3' => 1,
                ]);
                $createMemo = MemoModel::create([
                    'member_id' => auth('api')->user()->id,
                    'sender_id' => 1,
                    'subject' => 'Bonus turnover',
                    'is_reply' => 1,
                    'is_bonus' => 1,
                    'content' => 'Selamat Anda Mendapatkan Bonus Turnover Sebesar Rp 200.000',
                    'created_at' => Carbon::now(),
                ]);

                return $this->successResponse(null, 'Selamat anda mendapatkan bonus turnover sebesar Rp 200.000', 200);
            } elseif ($bets->Balance >= 300000000 && $bets->Balance <= 499999999 && $turnover->is_turnover4 == 0 && $enableTurnover->enabled == 1) {
                $creditMember->update([
                    'credit' => $creditMember->credit + 300000,
                ]);
                $turnover->update([
                    'is_turnover4' => 1,
                ]);
                $createMemo = MemoModel::create([
                    'member_id' => auth('api')->user()->id,
                    'sender_id' => 1,
                    'subject' => 'Bonus turnover',
                    'is_reply' => 1,
                    'is_bonus' => 1,
                    'content' => 'Selamat Anda Mendapatkan Bonus Turnover Sebesar Rp 300.000',
                    'created_at' => Carbon::now(),
                ]);

                return $this->successResponse(null, 'Selamat anda mendapatkan bonus turnover sebesar Rp 300.000', 200);
            } elseif ($bets->Balance >= 500000000 && $bets->Balance <= 999999999 && $turnover->is_turnover5 == 0 && $enableTurnover->enabled == 1) {
                $creditMember->update([
                    'credit' => $creditMember->credit + 600000,
                ]);
                $turnover->update([
                    'is_turnover5' => 1,
                ]);
                $createMemo = MemoModel::create([
                    'member_id' => auth('api')->user()->id,
                    'sender_id' => 1,
                    'subject' => 'Bonus turnover',
                    'is_reply' => 1,
                    'is_bonus' => 1,
                    'content' => 'Selamat Anda Mendapatkan Bonus Turnover Sebesar Rp 600.000',
                    'created_at' => Carbon::now(),
                ]);

                return $this->successResponse(null, 'Selamat anda mendapatkan bonus turnover sebesar Rp 600.000', 200);
            } elseif ($bets->Balance >= 1000000000 && $bets->Balance <= 1999999999 && $turnover->is_turnover6 == 0 && $enableTurnover->enabled == 1) {
                $creditMember->update([
                    'credit' => $creditMember->credit + 1500000,
                ]);
                $turnover->update([
                    'is_turnover6' => 1,
                ]);
                $createMemo = MemoModel::create([
                    'member_id' => auth('api')->user()->id,
                    'sender_id' => 1,
                    'subject' => 'Bonus turnover',
                    'is_reply' => 1,
                    'is_bonus' => 1,
                    'content' => 'Selamat Anda Mendapatkan Bonus Turnover Sebesar Rp 1.500.000',
                    'created_at' => Carbon::now(),
                ]);

                return $this->successResponse(null, 'Selamat Anda Mendapatkan Bonus Turnover Sebesar Rp 1.500.000', 200);
            } elseif ($bets->Balance >= 2000000000 && $bets->Balance <= 4999999999 && $turnover->is_turnover7 == 0 && $enableTurnover->enabled == 1) {
                $creditMember->update([
                    'credit' => $creditMember->credit + 3000000,
                ]);
                $turnover->update([
                    'is_turnover7' => 1,
                ]);
                $createMemo = MemoModel::create([
                    'member_id' => auth('api')->user()->id,
                    'sender_id' => 1,
                    'subject' => 'Bonus turnover',
                    'is_reply' => 1,
                    'is_bonus' => 1,
                    'content' => 'Selamat Anda Mendapatkan Bonus Turnover Sebesar Rp 3.000.000',
                    'created_at' => Carbon::now(),
                ]);

                return $this->successResponse(null, 'Selamat anda mendapatkan bonus turnover sebesar Rp 3.000.000', 200);
            } elseif ($bets->Balance >= 5000000000 && $bets->Balance <= 9999999999 && $turnover->is_turnover8 == 0 && $enableTurnover->enabled == 1) {
                $createMemo = MemoModel::create([
                    'member_id' => auth('api')->user()->id,
                    'sender_id' => 1,
                    'subject' => 'Bonus turnover',
                    'is_reply' => 1,
                    'is_bonus' => 1,
                    'content' => 'Selamat Anda Mendapatkan Hp Samsung S21+ Ultra 128gb, Silahkan hubungi cs kami',
                    'created_at' => Carbon::now(),
                ]);
                $turnover->update([
                    'is_turnover8' => 1,
                ]);

                return $this->successResponse(null, 'Selamat Anda Mendapatkan Hp Samsung S21+ Ultra 128gb, Silahkan hubungi cs kami', 200);
            } elseif ($bets->Balance >= 10000000000 && $bets->Balance <= 24999999999 && $turnover->is_turnover9 == 0 && $enableTurnover->enabled == 1) {
                $createMemo = MemoModel::create([
                    'member_id' => auth('api')->user()->id,
                    'sender_id' => 1,
                    'subject' => 'Bonus turnover',
                    'is_reply' => 1,
                    'is_bonus' => 1,
                    'content' => 'Selamat Anda Mendapatkan Hp Iphone 12 Pro Max 256GB, Silahkan hubungi cs kami',
                    'created_at' => Carbon::now(),
                ]);
                $turnover->update([
                    'is_turnover9' => 1,
                ]);

                return $this->successResponse(null, 'Selamat Anda Mendapatkan Hp Iphone 12 Pro Max 256GB, Silahkan hubungi cs kami', 200);
            } elseif ($bets->Balance >= 25000000000 && $bets->Balance <= 49999999999 && $turnover->is_turnover1 == 0 && $enableTurnover->enabled == 1) {
                $createMemo = MemoModel::create([
                    'member_id' => auth('api')->user()->id,
                    'sender_id' => 1,
                    'subject' => 'Bonus turnover',
                    'is_reply' => 1,
                    'is_bonus' => 1,
                    'content' => 'Selamat Anda Mendapatkan Yamaha XMAX 250, Silahkan hubungi cs kami',
                    'created_at' => Carbon::now(),
                ]);
                $turnover->update([
                    'is_turnover10' => 1,
                ]);

                return $this->successResponse(null, 'Selamat Anda Mendapatkan Yamaha XMAX 250, Silahkan hubungi cs kami', 200);
            } elseif ($bets->Balance >= 50000000000 && $bets->Balance <= 99999999999 && $turnover->is_turnover1 == 0 && $enableTurnover->enabled == 1) {
                $createMemo = MemoModel::create([
                    'member_id' => auth('api')->user()->id,
                    'sender_id' => 1,
                    'subject' => 'Bonus turnover',
                    'is_reply' => 1,
                    'is_bonus' => 1,
                    'content' => 'Selamat Anda Mendapatkan Kawasaki Z126 PRO 2021, Silahkan hubungi cs kami',
                    'created_at' => Carbon::now(),
                ]);
                $turnover->update([
                    'is_turnover11' => 1,
                ]);

                return $this->successResponse(null, 'Selamat Anda Mendapatkan Kawasaki Z126 PRO 2021, Silahkan hubungi cs kami', 200);
            } elseif ($bets->Balance >= 100000000000 && $bets->Balance <= 999999999999 && $turnover->is_turnover1 == 0 && $enableTurnover->enabled == 1) {
                $createMemo = MemoModel::create([
                    'member_id' => auth('api')->user()->id,
                    'sender_id' => 1,
                    'subject' => 'Bonus turnover',
                    'is_reply' => 1,
                    'is_bonus' => 1,
                    'content' => 'Selamat Anda Mendapatkan Honda Accord 2021, Silahkan hubungi cs kami',
                    'created_at' => Carbon::now(),
                ]);
                $turnover->update([
                    'is_turnover12' => 1,
                ]);

                return $this->successResponse(null, 'Selamat Anda Mendapatkan Honda Accord 2021, Silahkan hubungi cs kami', 200);
            } elseif ($bets->Balance >= 1000000000000) {
                $createMemo = MemoModel::create([
                    'member_id' => auth('api')->user()->id,
                    'sender_id' => 1,
                    'subject' => 'Bonus turnover',
                    'is_reply' => 1,
                    'is_bonus' => 1,
                    'content' => 'Selamat Anda Mendapatkan Honda Accord 2021, Silahkan hubungi cs kami',
                    'created_at' => Carbon::now(),
                ]);
                $turnover->update([
                    'is_turnover13' => 1,
                ]);

                return $this->successResponse(null, 'Selamat Anda Mendapatkan Honda Accord 2021, Silahkan hubungi cs kami', 200);
            } else {
                return $this->successResponse(null, 'Tidak ada bonus turnover yang di peroleh', 200);
            }
        }

        try {
        } catch (\Exception $e) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }
    // Cashback slot
    public function cashbackSlot()
    {
        try {
            $dt = Carbon::now();
            if ($dt->dayOfWeek == Carbon::SUNDAY) {
                $date = Carbon::now()->subDays(7);
                $date->format('Y-m-d');
                // dd($getMember);
                $cbMember = BetModel::join('members', 'members.id', '=', 'bets.created_by')
                ->select(
                    'members.id AS member_id',
                    DB::raw("(sum(bets.win)) - (sum(bets.bet)) as Balance"),
                )
                    ->where('bets.created_at', '>=', $date)
                    ->where('bets.created_by', auth('api')->user()->id)
                    ->groupBy('bets.created_by')->first();
                //  -1 < 0 > 1
                if (is_null($cbMember)) {
                    return $this->successResponse(null, 'Belum Pernah Melakukan Betting', 200);
                } elseif ($cbMember->Balance < 0) {
                    if ($cbMember->Balance > (-50000)) {
                        return $this->successResponse(null, 'No CASHBACK 123', 200);
                    } elseif ($cbMember->Balance <= -50000 && $cbMember->Balance >= -10000000) {
                        #tambah cashback to credit member
                        $member = MembersModel::find($cbMember->member_id);
                        $data1 = $cbMember->Balance - $cbMember->Balance - $cbMember->Balance;
                        $cashback5 = $data1 * 5 / 100;
                        $member->update([
                            'credit' => $cashback5,
                        ]);

                        #create memo after get cashback
                        $createMemo = MemoModel::create([
                            'member_id' => $cbMember->member_id,
                            'sender_id' => 1,
                            'subject' => 'CASHBACK 5%',
                            'is_reply' => 1,
                            'is_bonus' => 1,
                            'content' => 'Selamat Anda Mendapatkan CASHBACK 5% = '. $cashback5,
                            'created_at' => Carbon::now(),
                        ]);

                        return $this->successResponse(null, 'CASHBACK 5% Min', 200);
                    } elseif ($cbMember->Balance <= -10001000 && $cbMember->Balance >= -100000000) {
                        #tambah cashback to credit member
                        $member = MembersModel::find($cbMember->member_id);
                        $data1 = $cbMember->Balance - $cbMember->Balance - $cbMember->Balance;
                        $cashback7 = $data1 * 7 / 100;
                        $member->update([
                            'credit' => $cashback7,
                        ]);

                        #create memo after get cashback
                        $createMemo = MemoModel::create([
                            'member_id' => $cbMember->member_id,
                            'sender_id' => 1,
                            'subject' => 'CASHBACK 7%',
                            'is_reply' => 1,
                            'is_bonus' => 1,
                            'content' => 'Selamat Anda Mendapatkan CASHBACK 7% = '.$cashback7,
                            'created_at' => Carbon::now(),
                        ]);

                        return $this->successResponse(null, 'CASHBACK 7% Min', 200);
                    } elseif ($cbMember->Balance <= -100001000 && $cbMember->Balance >= -100000000000) {
                        #tambah cashback to credit member
                        $member = MembersModel::find($cbMember->member_id);
                        $data1 = $cbMember->Balance - $cbMember->Balance - $cbMember->Balance;
                        $cashback10 = $data1 * 10 / 100;
                        $member->update([
                            'credit' => $cashback10,
                        ]);

                        #create memo after get cashback
                        $createMemo = MemoModel::create([
                            'member_id' => $cbMember->member_id,
                            'sender_id' => 1,
                            'subject' => 'CASHBACK 10%',
                            'is_reply' => 1,
                            'is_bonus' => 1,
                            'content' => 'Selamat Anda Mendapatkan CASHBACK 10% = '.$cashback10,
                            'created_at' => Carbon::now(),
                        ]);

                        return $this->successResponse(null, 'CASHBACK 10%', 200);
                    } else {
                        return $this->successResponse(null, 'No CASHBACK 123', 200);
                    }
                } else {
                    return $this->successResponse(null, 'Tidak ada bonus cashback slot yang di peroleh', 200);
                }
            }
        } catch (\Throwable $th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }



    // public function setBonusNextDeposit()
    // {
    //     $cekKondisi = DepositModel::where('approval_status', 1)->orderBy('approval_status_at', 'ASC')->limit(3)->get();
    //     $data = $this->cek = $cekKondisi->toArray();
    //     if($data === []){
    //         return 'no data';
    //     }else{
    //         $member = DB::table('members')->update(['is_next_deposit' => 0]);
    //         return 'sukses changed';
    //     }
    // }

    // pagination
    public function paginate($items, $perPage, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
