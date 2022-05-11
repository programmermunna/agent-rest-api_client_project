<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Models\BetModel;
use App\Models\BetsTogel;
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
use App\Models\ConstantProviderTogelModel;
use App\Models\BonusHistoryModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
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
  public $gameHallBet = [];
  public $ionxBet = [];
  public $queenmakerBet = [];
  public $allProviderBet = [];
  public $pageAll = 10;
  public $togel = [];

  // history by type
  public function historyAll(Request $request)
  {
    try {
      $id = auth('api')->user()->id;
      $deposit = DB::select(\DB::raw("
                  SELECT
                      credit,
                      jumlah,
                      approval_status,
                      created_at,
                      created_by,
                      if (
                        approval_status = 0
                          , 'Pending'
                          , if (
                              approval_status = 1
                              , 'Success'
                              , if (
                                  approval_status = 2
                                  , 'Rejected'
                                  , 'nulled'
                              )
                          )
                      ) as 'deposit status'
                  FROM
                      deposit
                  WHERE
                    (created_by = $id AND deleted_at IS NULL) OR deleted_at IS NOT NULL AND created_by = $id
                  ORDER BY
                      created_at
                  DESC"));
      
      $withdraw = DB::select(\DB::raw("
                  SELECT
                      credit,
                      jumlah,
                      approval_status,
                      created_at,
                      created_by,
                      if (
                        approval_status = 0
                          , 'Pending'
                          , if (
                              approval_status = 1
                              , 'Success'
                              , if (
                                  approval_status = 2
                                  , 'Rejected'
                                  , 'nulled'
                              )
                          )
                      ) as 'Withdraw status'
                  FROM
                      withdraw
                  WHERE
                      (created_by = $id AND deleted_at IS NULL) OR deleted_at IS NOT NULL AND created_by = $id
                  ORDER BY
                      created_at
                  DESC"));


      $query = BetModel::join('members', 'members.id', '=', 'bets.created_by')
        ->join('constant_provider', 'constant_provider.id', '=', 'bets.constant_provider_id');

      $bonus = BonusHistoryModel::join('constant_bonus', 'constant_bonus.id', '=', 'bonus_history.constant_bonus_id')
        ->select([
          'bonus_history.id',
          'constant_bonus.nama_bonus',
          'bonus_history.type',
          'bonus_history.jumlah',
          'bonus_history.hadiah',
          'bonus_history.created_at',
          'bonus_history.member_id',
        ])
        ->where('bonus_history.is_send', 1)
        ->where('bonus_history.member_id', '=', auth('api')->user()->id)
        ->where('bonus_history.jumlah', '>', 0);



      if ($request->type == 'deposit') {
        $this->deposit = $deposit;
        $depo = $this->paginate($this->deposit, $this->perPageDepo);

        $this->withdraw = $withdraw;
        $wd = $this->paginate($this->withdraw, $this->perPageWd);

        return [
          'status' => 'success',  
          'deposit' => $depo,
          'withdraw' => $wd,
        ];
      } elseif ($request->type == 'pragmaticSlot') {
        $pragmaticSlot = $query->select(
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
        )
          ->where('bets.created_by', auth('api')->user()->id)
          ->where('bets.constant_provider_id', 1)
          ->orderBy('bets.created_at', 'desc')->get();

        // $this->pragmaticBet = $pragmBet->toArray();
        $data = $this->paginate($pragmaticSlot->toArray(), $this->perPage);

        return [
          'status' => 'success',
          'pragmaticSlot' => $data,
        ];
      } elseif ($request->type == 'pragmaticCasino') {
        $pragmaticCasino = $query->select(
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
        )
          ->where('bets.created_by', auth('api')->user()->id)
          ->where('bets.constant_provider_id', 10)
          ->orderBy('bets.created_at', 'desc')->get();

        // $this->pragmaticBet = $pragmBet->toArray();
        $data = $this->paginate($pragmaticCasino->toArray(), $this->perPage);

        return [
          'status' => 'success',
          'pragmaticCasino' => $data,
        ];
      } elseif ($request->type == 'habaneroSlot') {
        $habaneroSlot = $query->select(
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
        )
          ->where('bets.created_by', auth('api')->user()->id)
          ->where('bets.constant_provider_id', 2)
          ->orderBy('bets.created_at', 'desc')->get();

        // $this->habaneroBet = $habaneBet->toArray();
        $data = $this->paginate($habaneroSlot->toArray(), $this->perPage);

        return [
          'status' => 'success',
          'habaneroSlot' => $data,
        ];
      } elseif ($request->type == 'jokerSlot') {
        $jokerSlot = $query->select(
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
        )
          ->where('bets.created_by', auth('api')->user()->id)
          ->where('bets.constant_provider_id', 3)
          ->orderBy('bets.created_at', 'desc')->get();

        // $this->jokerBet = $jokBet->toArray();
        $data = $this->paginate($jokerSlot->toArray(), $this->perPage);

        return [
          'status' => 'success',
          'jokerSlot' => $data,
        ];
      } elseif ($request->type == 'jokerFish') {
        $jokerFish = $query->select(
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
        )
          ->where('bets.created_by', auth('api')->user()->id)
          ->where('bets.constant_provider_id', 13)
          ->orderBy('bets.created_at', 'desc')->get();

        // $this->jokerBet = $jokBet->toArray();
        $data = $this->paginate($jokerFish->toArray(), $this->perPage);

        return [
          'status' => 'success',
          'jokerFish' => $data,
        ];
      } elseif ($request->type == 'spadeSlot') {
        $spadeSlot = $query->select(
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
        )
          ->where('bets.created_by', auth('api')->user()->id)
          ->where('bets.constant_provider_id', 4)
          ->orderBy('bets.created_at', 'desc')->get();

        // $this->gamehallBet = $ghBet->toArray();
        $data = $this->paginate($spadeSlot->toArray(), $this->perPage);

        return [
          'status' => 'success',
          'spadeSlot' => $data,
        ];
      } elseif ($request->type == 'spadeFish') {
        $spadeFish = $query->select(
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
        )
          ->where('bets.created_by', auth('api')->user()->id)
          ->where('bets.constant_provider_id', 14)
          ->orderBy('bets.created_at', 'desc')->get();

        // $this->gamehallBet = $ghBet->toArray();
        $data = $this->paginate($spadeFish->toArray(), $this->perPage);

        return [
          'status' => 'success',
          'spadeFish' => $data,
        ];
      } elseif ($request->type == 'pgSlot') {
        $pgSlot = $query->select(
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
        )
          ->where('bets.created_by', auth('api')->user()->id)
          ->where('bets.constant_provider_id', 5)
          ->orderBy('bets.created_at', 'desc')->get();

        // $this->pgBet = $pBet->toArray();
        $data = $this->paginate($pgSlot->toArray(), $this->perPage);

        return [
          'status' => 'success',
          'pgSlot' => $data,
        ];
      } elseif ($request->type == 'playtechSlot') {
        $playtechSlot = $query->select(
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
        )
          ->where('bets.created_by', auth('api')->user()->id)
          ->where('bets.constant_provider_id', 6)
          ->orderBy('bets.created_at', 'desc')->get();
        // $this->playtechBet = $playBet->toArray();
        $data = $this->paginate($playtechSlot->toArray(), $this->perPage);

        return [
          'status' => 'success',
          'playtechSlot' => $data,
        ];
      } elseif ($request->type == 'jdbSlot') {
        $jdbSlot = $query->select(
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
        )
          ->where('bets.created_by', auth('api')->user()->id)
          ->where('bets.constant_provider_id', 7)
          ->orderBy('bets.created_at', 'desc')->get();

        // $this->gamehallBet = $ghBet->toArray();
        $data = $this->paginate($jdbSlot->toArray(), $this->perPage);

        return [
          'status' => 'success',
          'jdbSlot' => $data,
        ];
      } elseif ($request->type == 'jdbFish') {
        $jdbFish = $query->select(
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
        )
          ->where('bets.created_by', auth('api')->user()->id)
          ->where('bets.constant_provider_id', 15)
          ->orderBy('bets.created_at', 'desc')->get();

        // $this->gamehallBet = $ghBet->toArray();
        $data = $this->paginate($jdbFish->toArray(), $this->perPage);

        return [
          'status' => 'success',
          'jdbFish' => $data,
        ];
      } elseif ($request->type == 'sexyGCasino') {
        $sexyGCasino = $query->select(
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
        )
          ->where('bets.created_by', auth('api')->user()->id)
          ->where('bets.constant_provider_id', 11)
          ->orderBy('bets.created_at', 'desc')->get();

        // $this->gamehallBet = $ghBet->toArray();
        $data = $this->paginate($sexyGCasino->toArray(), $this->perPage);

        return [
          'status' => 'success',
          'sexyGCasino' => $data,
        ];
      } elseif ($request->type == 'ionxCasino') {
        $ionxCasino = $query->select(
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
        )
          ->where('bets.created_by', auth('api')->user()->id)
          ->where('bets.constant_provider_id', 8)
          ->orderBy('bets.created_at', 'desc')->get();

        // $this->ionxBet = $iBet->toArray();
        $data = $this->paginate($ionxCasino->toArray(), $this->perPage);

        return [
          'status' => 'success',
          'ionxCasino' => $data,
        ];
      } elseif ($request->type == 'oneGSlot') {
        $oneGSlot = $query->select(
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
        )
          ->where('bets.created_by', auth('api')->user()->id)
          ->where('bets.constant_provider_id', 9)
          ->orderBy('bets.created_at', 'desc')->get();

        // $this->queenmakerBet = $qmBet->toArray();
        $data = $this->paginate($oneGSlot->toArray(), $this->perPage);

        return [
          'status' => 'success',
          'oneGSlot' => $data,
        ];
      } elseif ($request->type == 'redTSlot') {
        $redTSlot = $query->select(
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
        )
          ->where('bets.created_by', auth('api')->user()->id)
          ->where('bets.constant_provider_id', 12)
          ->orderBy('bets.created_at', 'desc')->get();

        // $this->queenmakerBet = $qmBet->toArray();
        $data = $this->paginate($redTSlot->toArray(), $this->perPage);

        return [
          'status' => 'success',
          'redTSlot' => $data,
        ];
      } elseif ($request->type == 'BonusPromo') {
        $this->bonus = $bonus->get()->toArray();
        $bonusArr = $this->paginate($this->bonus, $this->perPage);

        return  [
          'status' => 'success',
          'BonusPromo' => $bonusArr,
        ];
      } elseif ($request->type == 'togel') {

        $togel = $this->paginate($this->getTogel(), $this->perPage);

        return [
          'status' => 'success',
          'togel' => $togel,
        ];
      } else {
        // $this->deposit = $deposit->get()->toArray();
        // $depo = $this->paginate($this->deposit, $this->pageAll);

        // $this->withdraw = $withdraw->get()->toArray();
        // $wd = $this->paginate($this->withdraw, $this->pageAll);

        //all provider bet
        // $allProBet = BetModel::join('members', 'members.id', '=', 'bets.created_by')
        //   ->join('constant_provider', 'constant_provider.id', '=', 'bets.constant_provider_id')
        //   ->select(
        //     'bets.bet',
        //     'bets.win',
        //     'bets.game_info',
        //     'bets.bet_id',
        //     'bets.game_id',
        //     'bets.deskripsi',
        //     'bets.credit',
        //     'bets.created_at',
        //     'constant_provider.constant_provider_name'
        //   )->where('bets.created_by', auth('api')->user()->id)->get();

        // $this->allProviderBet = $allProBet->toArray();

        // $this->bonus = $bonus->get()->toArray();
        // // all bonus here
        // $bonusArr = $this->paginate($this->bonus, $this->pageAll);

        // $togel = $this->paginate($this->togel, $this->perPage);

        // $margeResult = array_merge([$this->deposit, $this->withdraw, $allProBet->toArray(), $this->bonus, $this->getTogel()]);

        // $result = collect();

        // foreach ($margeResult as  $row) {
        //   foreach ($row as  $value) {
        //     $result->push($value);
        //   }
        // }
        // return $this->paginate($result, $this->pageAll);      

        $allProBet = DB::select(\DB::raw("SELECT 
                  'Bets' AS Tables,
                  a.bet as betsBet,
                  a.win as betsWin,
                  a.game_info as betsGameInfo,
                  a.bet_id as betsBetId,
                  a.game_id as betsGameId,
                  a.deskripsi as betsDeskripsi,
                  a.credit as betsCredit,
                  a.created_at as created_at,
                  c.constant_provider_name as betsProviderName,
                  NULL as betsTogelHistoryId,
                  NULL as betsTogelHistoryPasaran,
                  NULL as betsTogelHistorDeskripsi,
                  NULL as betsTogelHistoryDebit,
                  NULL as betsTogelHistoryKredit,
                  NULL as betsTogelHistoryBalance,
                  NULL as betsTogelHistoryCreatedBy,
                  NULL as depositCredit,
                  NULL as depositJumlah,
                  NULL as depositStatus,
                  NULL as depositDescription,
                  NULL as withdrawCredit,
                  NULL as withdrawJumlah,
                  NULL as withdrawStatus,
                  NULL as withdrawDescription,
                  NULL as bonusHistoryNamaBonus,
                  NULL as bonusHistoryType,
                  NULL as bonusHistoryJumlah,
                  NULL as bonusHistoryHadiah,
                  NULL as bonusHistoryCreatedBy, 
                  NULL as activityDeskripsi, 
                  NULL as activityName,
                  NULL as detail 
              FROM bets as a
              LEFT JOIN members as b ON a.created_by = b.id
              LEFT JOIN constant_provider as c ON a.constant_provider_id = c.id              
              WHERE a.created_by = $id
              -- UNION ALL
              -- SELECT
              --     'Bets Togel History' as Tables,
              --     NULL as betsBet,
              --     NULL as betsWin,
              --     NULL as betsGameInfo,
              --     NULL as betsBetId,
              --     NULL as betsGameId,
              --     NULL as betsDeskripsi,
              --     NULL as betsCredit,
              --     a.created_at as created_at,
              --     NULL as betsProviderName,                  
              --     a.bets_togel_id as betsTogelHistoryId,
              --     CONCAT(c.name_initial, '-', b.period) as betsTogelHistoryPasaran,
              --     a.description as betsTogelHistorDeskripsi,
              --     a.debit as betsTogelHistoryDebit,
              --     a.kredit as betsTogelHistoryKredit,
              --     a.balance as betsTogelHistoryBalance,
              --     a.created_by as betsTogelHistoryCreatedBy,
              --     NULL as depositCredit,
              --     NULL as depositJumlah,
              --     NULL as depositStatus,
              --     NULL as depositDescription,
              --     NULL as withdrawCredit,
              --     NULL as withdrawJumlah,
              --     NULL as withdrawStatus,
              --     NULL as withdrawDescription,
              --     NULL as bonusHistoryNamaBonus,
              --     NULL as bonusHistoryType,
              --     NULL as bonusHistoryJumlah,
              --     NULL as bonusHistoryHadiah,
              --     NULL as bonusHistoryCreatedBy,
              --     NULL as activityDeskripsi,
              --     NULL as activityName
              -- FROM bets_togel_history_transaksi as a
              -- LEFT JOIN bets_togel as b ON a.bets_togel_id = b.id
              -- LEFT JOIN constant_provider_togel as c ON b.constant_provider_togel_id = c.id
              -- WHERE a.created_by = $id
              UNION ALL
              SELECT
                  'Deposit' as Tables,
                  NULL as betsBet,
                  NULL as betsWin,
                  NULL as betsGameInfo,
                  NULL as betsBetId,
                  NULL as betsGameId,
                  NULL as betsDeskripsi,
                  NULL as betsCredit,
                  a.created_at as created_at,
                  NULL as betsProviderName,
                  NULL as betsTogelHistoryId,
                  NULL as betsTogelHistoryPasaran,
                  NULL as betsTogelHistorDeskripsi,
                  NULL as betsTogelHistoryDebit,
                  NULL as betsTogelHistoryKredit,
                  NULL as betsTogelHistoryBalance,
                  NULL as betsTogelHistoryCreatedBy,
                  a.credit as depositCredit,
                  a.jumlah as depositJumlah,
                  a.approval_status as depositStatus,
                  if (
                    a.approval_status = 0
                      , 'Pending'
                      , if (
                          a.approval_status = 1
                          , 'Success'
                          , if (
                              a.approval_status = 2
                              , 'Rejected'
                              , 'nulled'
                          )
                      )
                  ) as 'depositDescription',
                  NULL as withdrawCredit,
                  NULL as withdrawJumlah,
                  NULL as withdrawStatus,
                  NULL as withdrawDescription,
                  NULL as bonusHistoryNamaBonus,
                  NULL as bonusHistoryType,
                  NULL as bonusHistoryJumlah,
                  NULL as bonusHistoryHadiah,
                  NULL as bonusHistoryCreatedBy,
                  NULL as activityDeskripsi,
                  NULL as activityName,
                  NULL as detail
              FROM
                  deposit as a
              LEFT JOIN members as b ON b.id = a.created_by
              
              WHERE
                  (a.created_by = $id AND a.deleted_at IS NULL) OR a.deleted_at IS NOT NULL AND a.created_by = $id
              UNION ALL
              SELECT
                  'Withdraw' as Tables,
                  NULL as betsBet,
                  NULL as betsWin,
                  NULL as betsGameInfo,
                  NULL as betsBetId,
                  NULL as betsGameId,
                  NULL as betsDeskripsi,
                  NULL as betsCredit,
                  a.created_at as created_at,
                  NULL as betsProviderName,
                  NULL as betsTogelHistoryId,
                  NULL as betsTogelHistoryPasaran,
                  NULL as betsTogelHistorDeskripsi,
                  NULL as betsTogelHistoryDebit,
                  NULL as betsTogelHistoryKredit,
                  NULL as betsTogelHistoryBalance,
                  NULL as betsTogelHistoryCreatedBy,
                  NULL as depositCredit,
                  NULL as depositJumlah,
                  NULL as depositStatus,
                  NULL as depositDescription,
                  a.credit as withdrawCredit,
                  a.jumlah as withdrawJumlah,
                  a.approval_status as withdrawStatus,
                  if (
                    a.approval_status = 0
                      , 'Pending'
                      , if (
                          a.approval_status = 1
                          , 'Success'
                          , if (
                              a.approval_status = 2
                              , 'Rejected'
                              , 'nulled'
                          )
                      )
                  ) as 'withdrawDescription',
                  NULL as bonusHistoryNamaBonus,
                  NULL as bonusHistoryType,
                  NULL as bonusHistoryJumlah,
                  NULL as bonusHistoryHadiah,
                  NULL as bonusHistoryCreatedBy,
                  NULL as activityDeskripsi,
                  NULL as activityName,
                  NULL as detail
              FROM
                  withdraw as a
              LEFT JOIN members as b ON b.id = a.created_by              
              WHERE
                (a.created_by = $id AND a.deleted_at IS NULL) OR a.deleted_at IS NOT NULL AND a.created_by = $id
              UNION ALL
              SELECT
                  'Bonus History' as Tables,
                  NULL as betsBet,
                  NULL as betsWin,
                  NULL as betsGameInfo,
                  NULL as betsBetId,
                  NULL as betsGameId,
                  NULL as betsDeskripsi,
                  NULL as betsCredit,
                  a.created_at as created_at,
                  NULL as betsProviderName,
                  NULL as betsTogelHistoryId,
                  NULL as betsTogelHistoryPasaran,
                  NULL as betsTogelHistorDeskripsi,
                  NULL as betsTogelHistoryDebit,
                  NULL as betsTogelHistoryKredit,
                  NULL as betsTogelHistoryBalance,
                  NULL as betsTogelHistoryCreatedBy,
                  NULL as depositCredit,
                  NULL as depositJumlah,
                  NULL as depositStatus,
                  NULL as depositDescription,
                  NULL as withdrawCredit,
                  NULL as withdrawJumlah,
                  NULL as withdrawStatus,
                  NULL as withdrawDescription,
                  b.nama_bonus as bonusHistoryNamaBonus,
                  a.type as bonusHistoryType,
                  a.jumlah as bonusHistoryJumlah,
                  a.hadiah as bonusHistoryHadiah,
                  a.created_by as bonusHistoryCreatedBy,
                  NULL as activityDeskripsi,
                  NULL as activityName,
                  NULL as detail
              FROM
                  bonus_history as a
              LEFT JOIN constant_bonus as b ON b.id = a.constant_bonus_id              
              WHERE a.created_by = $id AND a.jumlah > 0 AND a.deleted_at IS NULL
              ORDER BY created_at DESC"));

        $activity_members = DB::select("SELECT
                                properties,
                                created_at
                            FROM
                                activity_log
                            WHERE
                                log_name = 'Member Login' OR log_name ='Member Log Out'");
        $properties = [];
        foreach ($activity_members as $activity) {
          $array = json_decode($activity->properties, true);
          if(array_push($array) == 3){
            $device = Arr::add($array, 'device', null);
            $properties [] = Arr::add($device, 'created_at', $activity->created_at);
          } else {
            $properties [] = Arr::add($array, 'created_at', $activity->created_at);
          }            
        };
        
        $member = MembersModel::where('id', auth('api')->user()->id)->first();
        $activity = [];
        foreach ($properties as $index => $json) {
          if ($json['target'] == $member->username) {
              $activity[] = $json;
          }
        }

        $activitys = [];
        foreach ($activity as $key => $value) {
          $activity = [
            'Tables' => 'Activity',
            'betsBet' => null,
            'betsWin' => null,
            'betsGameInfo' => null,
            'betsBetId' => null,
            'betsGameId' => null,
            'betsDeskripsi' => null,
            'betsCredit' => null,
            'created_at' => $value['created_at'],
            'betsProviderName' => null,
            'betsTogelHistoryId' => null,
            'betsTogelHistoryPasaran' => null, 
            'betsTogelHistorDeskripsi' => null,
            'betsTogelHistoryDebit' => null,
            'betsTogelHistoryKredit' => null,
            'betsTogelHistoryBalance' => null,
            'betsTogelHistoryCreatedBy' => null,
            'depositCredit' => null,
            'depositJumlah' => null,
            'depositStatus' => null,
            'depositDescription' => null,
            'withdrawCredit' => null,
            'withdrawJumlah' => null,
            'withdrawStatus' => null,
            'withdrawDescription' => null,
            'bonusHistoryNamaBonus' => null,
            'bonusHistoryType' => null,
            'bonusHistoryJumlah' => null,
            'bonusHistoryHadiah' => null,
            'bonusHistoryCreatedBy' => null,
            'activityDeskripsi' => $value['device'] != null ? $value['activity']." : ".$value['device'] : $value['activity'], 
            'activityName' => $value['device'] != null ? $value['activity']." - ".$value['device'] : $value['activity'],
            'detail' => null
          ];
          $activitys[] = $activity;          
        };                
        $betTogelHistories = [];
        foreach ($this->dataTogel() as $key => $value) {        
          $betTogelHis = [
            'Tables' => 'Bets Togel History',
            'betsBet' => null,
            'betsWin' => null,
            'betsGameInfo' => null,
            'betsBetId' => null,
            'betsGameId' => null,
            'betsDeskripsi' => null,
            'betsCredit' => null,
            'created_at' => $value['created_at'],
            'betsProviderName' => null,
            'betsTogelHistoryId' => $value['id'],
            'betsTogelHistoryPasaran' => $value['Pasaran'], 
            'betsTogelHistorDeskripsi' => 'Bet : ('.$value['Game']. ' => '. $value['Nomor'].')',
            'betsTogelHistoryDebit' => $value['Bet'],
            'betsTogelHistoryKredit' => $value['winTogel'],
            'betsTogelHistoryBalance' => $value['balance'],
            'betsTogelHistoryCreatedBy' => $value['created_by'],
            'depositCredit' => null,
            'depositJumlah' => null,
            'depositStatus' => null,
            'depositDescription' => null,
            'withdrawCredit' => null,
            'withdrawJumlah' => null,
            'withdrawStatus' => null,
            'withdrawDescription' => null,
            'bonusHistoryNamaBonus' => null,
            'bonusHistoryType' => null,
            'bonusHistoryJumlah' => null,
            'bonusHistoryHadiah' => null,
            'bonusHistoryCreatedBy' => null,
            'activityDeskripsi' => null, 
            'activityName' => null,
            'detail' => '/endpoint/getDetailTransaksiTogel/'.$value['id']
          ];
          $betTogelHistories[] = $betTogelHis;          
        }

        $alldata1 = array_merge($allProBet, $activitys);
        $alldata2 = array_merge($alldata1, $betTogelHistories);
        $date = array_column($alldata2, 'created_at');
        array_multisort($date, SORT_DESC, $alldata2);
        $this->allProviderBet = $alldata2;
        // dd($alldata2);
        // var_dump($this->allProviderBet);
        $allProviderBet = $this->paginate($this->allProviderBet, $this->pageAll);
        return  [
          'status' => 'success',
          'allProviderBet' => $allProviderBet,
        ];
                          
      }
    } catch (\Throwable $th) {
      return $this->errorResponse($th->getMessage(), 500);
    }
  }

  // daily referal
  public function dailyReferal(Request $request)
  {
    try {
      $togel = $request->togel;
      $from_date = $request->from_date;
      $to_date = $request->to_date;

      $bonus = BetsTogel::join('members as a', 'a.id', '=', 'bets_togel.created_by')
        ->join('constant_provider_togel as b', 'b.id', '=', 'bets_togel.constant_provider_togel_id')
        ->join('togel_game as c', 'c.id', '=', 'bets_togel.togel_game_id')
        ->when($togel != '', function ($query) use ($togel) {
          $query->where('b.id', $togel);
        })
        ->whereDate('bets_togel.created_at', '>=', $from_date)
        ->whereDate('bets_togel.created_at', '<=', $to_date)
        ->select(
          'bets_togel.created_at',
          'a.username',
          'a.referrer_id',
          'bets_togel.win_lose_status',
          'bets_togel.created_at',
          'bets_togel.bonus_daily_referal',
          'b.name',
          'c.name as togel_game',
        );

      if ($bonus->count() < 1) {
        return $this->successResponse($bonus->get(), 'Tidak ada bonus harian', 200);
      } else {
        return $this->successResponse($bonus->get(), 'Ada bonus harian', 200);
      }
    } catch (\Throwable $th) {
      return $this->errorResponse($th->getMessage(), 500);
    }
  }

  public function getTogel()
  {
    $result = BetsTogel::join('members', 'bets_togel.created_by', '=', 'members.id')  
              ->join('constant_provider_togel', 'bets_togel.constant_provider_togel_id', '=', 'constant_provider_togel.id')  
              ->join('togel_game', 'bets_togel.togel_game_id', '=', 'togel_game.id')
              ->leftJoin('togel_shio_name', 'bets_togel.tebak_shio', '=', 'togel_shio_name.id')
              ->join('togel_setting_game', 'bets_togel.togel_setting_game_id', '=', 'togel_setting_game.id')
              ->selectRaw("
                  bets_togel.id,
                  bets_togel.balance,
                  constant_provider_togel.id as constant_provider_togel_id,
                  bets_togel.created_at
                  
                  , members.last_login_ip as 'IP'
                  , members.username as 'Username'
                  , concat(constant_provider_togel.name_initial, '-', bets_togel.period) as 'Pasaran'
                  , if (
                      bets_togel.number_6 is not null and bets_togel.number_5 is not null and bets_togel.number_4 is not null and bets_togel.number_3 is not null and bets_togel.number_2 is null and bets_togel.number_1 is null and bets_togel.togel_game_id = 1
                      , '4D'
                      , if (
                          bets_togel.number_6 is not null and bets_togel.number_5 is not null and bets_togel.number_4 is not null and bets_togel.number_3 is null and bets_togel.number_2 is null and bets_togel.number_1 is null and bets_togel.togel_game_id = 1 
                          , '3D'
                          , if (
                              bets_togel.number_6 is not null and bets_togel.number_5 is not null and bets_togel.number_4 is null and bets_togel.number_3 is null and bets_togel.number_2 is null and bets_togel.number_1 is null and bets_togel.togel_game_id = 1
                              , '2D'
                              , if (
                                  bets_togel.number_6 is null and bets_togel.number_5 is not null and bets_togel.number_4 is not null and bets_togel.number_3 is null and bets_togel.number_2 is null and bets_togel.number_1 is null and bets_togel.togel_game_id = 1
                                  , '2D Tengah'
                                  , if (
                                      bets_togel.number_6 is null and bets_togel.number_5 is null and bets_togel.number_4 is not null and bets_togel.number_3 is not null and bets_togel.number_2 is null and bets_togel.number_1 is null and bets_togel.togel_game_id = 1
                                      , '2D Depan'
                                      , togel_game.name
                                  )
                              )
                          )
                      )
                  ) as 'Game'
                  , if (
                      bets_togel.number_6 is not null and bets_togel.number_5 is not null and bets_togel.number_4 is not null and bets_togel.number_3 is not null and bets_togel.number_2 is null and bets_togel.number_1 is null
                      , concat(bets_togel.number_3, bets_togel.number_4, bets_togel.number_5, bets_togel.number_6)
                      , if (
                          bets_togel.number_6 is not null and bets_togel.number_5 is not null and bets_togel.number_4 is not null and bets_togel.number_3 is null and bets_togel.number_2 is null and bets_togel.number_1 is null
                          , concat(bets_togel.number_4, bets_togel.number_5, bets_togel.number_6)
                          , if (
                              bets_togel.number_6 is not null and bets_togel.number_5 is not null and bets_togel.number_4 is null and bets_togel.number_3 is null and bets_togel.number_2 is null and bets_togel.number_1 is null
                              , concat(bets_togel.number_5, bets_togel.number_6)
                              , if (
                                  bets_togel.number_6 is null and bets_togel.number_5 is not null and bets_togel.number_4 is not null and bets_togel.number_3 is null and bets_togel.number_2 is null and bets_togel.number_1 is null
                                  , concat(bets_togel.number_4, bets_togel.number_5)
                                  , if (
                                      bets_togel.number_6 is null and bets_togel.number_5 is null and bets_togel.number_4 is not null and bets_togel.number_3 is not null and bets_togel.number_2 is null and bets_togel.number_1 is null
                                      , concat(bets_togel.number_3, bets_togel.number_4)
                                      , if (
                                          togel_game.id = 5 and bets_togel.number_3 is null and bets_togel.number_4 is null and bets_togel.number_5 is null
                                          ,bets_togel.number_6
                                          , if (
                                              togel_game.id = 5 and bets_togel.number_3 is null and bets_togel.number_4 is null and bets_togel.number_6 is null
                                              ,bets_togel.number_5
                                              , if (
                                                  togel_game.id = 5 and bets_togel.number_3 is null and bets_togel.number_5 is null and bets_togel.number_6 is null
                                                  ,bets_togel.number_4
                                                  , if (
                                                      togel_game.id = 5 and bets_togel.number_4 is null and bets_togel.number_5 is null and bets_togel.number_6 is null
                                                      ,bets_togel.number_3
                                                      , if (
                                                          togel_game.id = 6
                                                          , concat(bets_togel.number_1, bets_togel.number_2)
                                                          , if (
                                                              togel_game.id = 7
                                                              , concat(bets_togel.number_1, bets_togel.number_2, bets_togel.number_3)
                                                              , if (
                                                                  togel_game.id = 8 and bets_togel.number_3 is null and bets_togel.number_4 is null and bets_togel.number_5 is null
                                                                  , concat(bets_togel.number_6, ' - ' , bets_togel.tebak_as_kop_kepala_ekor)
                                                                  , if (
                                                                      togel_game.id = 8 and bets_togel.number_3 is null and bets_togel.number_4 is null and bets_togel.number_6 is null
                                                                      , concat(bets_togel.number_5, ' - ' , bets_togel.tebak_as_kop_kepala_ekor)
                                                                      , if (
                                                                          togel_game.id = 8 and bets_togel.number_3 is null and bets_togel.number_5 is null and bets_togel.number_6 is null
                                                                          , concat(bets_togel.number_4, ' - ' , bets_togel.tebak_as_kop_kepala_ekor)
                                                                          , if (
                                                                              togel_game.id = 8 and bets_togel.number_4 is null and bets_togel.number_5 is null and bets_togel.number_6 is null
                                                                              , concat(bets_togel.number_3, ' - ' , bets_togel.tebak_as_kop_kepala_ekor)
                                                                              , if (
                                                                                  togel_game.id = 9
                                                                                  , if (
                                                                                      bets_togel.tebak_besar_kecil is null
                                                                                      , if (
                                                                                          bets_togel.tebak_genap_ganjil is null
                                                                                          , if (
                                                                                              bets_togel.tebak_tengah_tepi is null
                                                                                              , 'nulled'
                                                                                              , bets_togel.tebak_tengah_tepi
                                                                                          )
                                                                                          , bets_togel.tebak_genap_ganjil
                                                                                      )
                                                                                      , bets_togel.tebak_besar_kecil
                                                                                  )
                                                                                  , if (
                                                                                      togel_game.id = 10
                                                                                      , if (
                                                                                          bets_togel.tebak_as_kop_kepala_ekor = 'as' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                          , concat('as', '-', 'genap')
                                                                                          , if (
                                                                                              bets_togel.tebak_as_kop_kepala_ekor = 'as' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                              , concat('as', '-', 'ganjil')
                                                                                              , if (
                                                                                                  bets_togel.tebak_as_kop_kepala_ekor = 'kop' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                                  , concat('kop', '-', 'genap')
                                                                                                  , if (
                                                                                                      bets_togel.tebak_as_kop_kepala_ekor = 'kop' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                      , concat('kop', '-', 'ganjil')
                                                                                                      , if (
                                                                                                          bets_togel.tebak_as_kop_kepala_ekor = 'kepala' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                                          , concat('kepala', '-', 'genap')
                                                                                                          , if (
                                                                                                              bets_togel.tebak_as_kop_kepala_ekor = 'kepala' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                              , concat('kepala', '-', 'ganjil')
                                                                                                              , if (
                                                                                                                  bets_togel.tebak_as_kop_kepala_ekor = 'ekor' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                                                  , concat('ekor', '-', 'genap')
                                                                                                                  , if (
                                                                                                                      bets_togel.tebak_as_kop_kepala_ekor = 'ekor' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                                      , concat('ekor', '-', 'ganjil')
                                                                                                                      , if (
                                                                                                                          bets_togel.tebak_as_kop_kepala_ekor = 'as' and bets_togel.tebak_besar_kecil = 'besar'
                                                                                                                          , concat('as', '-', 'besar')
                                                                                                                          , if (
                                                                                                                              bets_togel.tebak_as_kop_kepala_ekor = 'as' and bets_togel.tebak_besar_kecil = 'kecil'
                                                                                                                              , concat('as', '-', 'kecil')
                                                                                                                              , if (
                                                                                                                                  bets_togel.tebak_as_kop_kepala_ekor = 'kop' and bets_togel.tebak_besar_kecil = 'besar'
                                                                                                                                  , concat('kop', '-', 'besar')
                                                                                                                                  , if (
                                                                                                                                      bets_togel.tebak_as_kop_kepala_ekor = 'kop' and bets_togel.tebak_besar_kecil = 'kecil'
                                                                                                                                      , concat('kop', '-', 'kecil')
                                                                                                                                      , if (
                                                                                                                                          bets_togel.tebak_as_kop_kepala_ekor = 'kepala' and bets_togel.tebak_besar_kecil = 'besar'
                                                                                                                                          , concat('kepala', '-', 'besar')
                                                                                                                                          , if (
                                                                                                                                              bets_togel.tebak_as_kop_kepala_ekor = 'kepala' and bets_togel.tebak_besar_kecil = 'kecil'
                                                                                                                                              , concat('kepala', '-', 'kecil')
                                                                                                                                              , if (
                                                                                                                                                  bets_togel.tebak_as_kop_kepala_ekor = 'ekor' and bets_togel.tebak_besar_kecil = 'besar'
                                                                                                                                                  , concat('ekor', '-', 'besar')
                                                                                                                                                  , if (
                                                                                                                                                      bets_togel.tebak_as_kop_kepala_ekor = 'ekor' and bets_togel.tebak_besar_kecil = 'kecil'
                                                                                                                                                      , concat('ekor', '-', 'kecil')
                                                                                                                                                      , 'nulled'
                                                                                                                                                  )
                                                                                                                                              )
                                                                                                                                          )
                                                                                                                                      )
                                                                                                                                  )
                                                                                                                              )
                                                                                                                          )
                                                                                                                      )
                                                                                                                  )
                                                                                                              )
                                                                                                          )
                                                                                                      )
                                                                                                  )
                                                                                              )
                                                                                          )
                                                                                      )
                                                                                      , if (
                                                                                          togel_game.id = 11
                                                                                          , if (
                                                                                              bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_mono_stereo = 'stereo'
                                                                                              , concat('belakang', ' - ', 'stereo')
                                                                                              , if (
                                                                                                  bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_mono_stereo = 'mono'
                                                                                                  , concat('belakang', ' - ', 'mono')
                                                                                                  , if (
                                                                                                      bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_kembang_kempis_kembar = 'kembang'
                                                                                                      , concat('belakang', ' - ', 'kembang')
                                                                                                      , if (
                                                                                                          bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_kembang_kempis_kembar = 'kempis'
                                                                                                          , concat('belakang', ' - ', 'kempis')
                                                                                                          , if (
                                                                                                              bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_kembang_kempis_kembar = 'kembar'
                                                                                                              , concat('belakang', ' - ', 'kembar')
                                                                                                              , if (
                                                                                                                  bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_mono_stereo = 'stereo'
                                                                                                                  , concat('tengah', ' - ', 'stereo')
                                                                                                                  , if (
                                                                                                                      bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_mono_stereo = 'mono'
                                                                                                                      , concat('tengah', ' - ', 'mono')
                                                                                                                      , if (
                                                                                                                          bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_kembang_kempis_kembar = 'kembang'
                                                                                                                          , concat('tengah', ' - ', 'kembang')
                                                                                                                          , if (
                                                                                                                              bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_kembang_kempis_kembar = 'kempis'
                                                                                                                              , concat('tengah', ' - ', 'kempis')
                                                                                                                              , if (
                                                                                                                                  bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_kembang_kempis_kembar = 'kembar'
                                                                                                                                  , concat('tengah', ' - ', 'kembar')
                                                                                                                                  , if (
                                                                                                                                      bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_mono_stereo = 'stereo'
                                                                                                                                      , concat('depan', ' - ', 'stereo')
                                                                                                                                      , if (
                                                                                                                                          bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_mono_stereo = 'mono'
                                                                                                                                          , concat('depan', ' - ', 'mono')
                                                                                                                                          , if (
                                                                                                                                              bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_kembang_kempis_kembar = 'kembang'
                                                                                                                                              , concat('depan', ' - ', 'kembang')
                                                                                                                                              , if (
                                                                                                                                                  bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_kembang_kempis_kembar = 'kempis'
                                                                                                                                                  , concat('depan', ' - ', 'kempis')
                                                                                                                                                  , if (
                                                                                                                                                      bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_kembang_kempis_kembar = 'kembar'
                                                                                                                                                      , concat('depan', ' - ', 'kembar')
                                                                                                                                                      , 'nulled'
                                                                                                                                                  )
                                                                                                                                              )
                                                                                                                                          )
                                                                                                                                      )
                                                                                                                                  )
                                                                                                                              )
                                                                                                                          )
                                                                                                                      )
                                                                                                                  )
                                                                                                              )
                                                                                                          )
                                                                                                      )
                                                                                                  )
                                                                                              )
                                                                                          )
                                                                                          , if (
                                                                                              togel_game.id = 12
                                                                                              , if (
                                                                                                  bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_besar_kecil = 'besar' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                                  , concat('belakang', '-', 'besar', '-', 'genap')
                                                                                                  , if (
                                                                                                      bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_besar_kecil = 'besar' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                      , concat('belakang', '-', 'besar', '-', 'ganjil')
                                                                                                      , if (
                                                                                                          bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_besar_kecil = 'kecil' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                                          , concat('belakang', '-', 'kecil', '-', 'genap')
                                                                                                          , if (
                                                                                                              bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_besar_kecil = 'kecil' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                              , concat('belakang', '-', 'kecil', '-', 'ganjil')
                                                                                                              , if (
                                                                                                                  bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_besar_kecil = 'besar' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                                                  , concat('tengah', '-', 'besar', '-', 'genap')
                                                                                                                  , if (
                                                                                                                      bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_besar_kecil = 'besar' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                                      , concat('tengah', '-', 'besar', '-', 'ganjil')
                                                                                                                      , if (
                                                                                                                          bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_besar_kecil = 'kecil' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                                                          , concat('tengah', '-', 'kecil', '-', 'genap')
                                                                                                                          , if (
                                                                                                                              bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_besar_kecil = 'kecil' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                                              , concat('tengah', '-', 'kecil', '-', 'ganjil')
                                                                                                                              , if (
                                                                                                                                  bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_besar_kecil = 'besar' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                                                                  , concat('depan', '-', 'besar', '-', 'genap')
                                                                                                                                  , if (
                                                                                                                                      bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_besar_kecil = 'besar' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                                                      , concat('depan', '-', 'besar', '-', 'ganjil')
                                                                                                                                      , if (
                                                                                                                                          bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_besar_kecil = 'kecil' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                                                                          , concat('depan', '-', 'kecil', '-', 'genap')
                                                                                                                                          , if (
                                                                                                                                              bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_besar_kecil = 'kecil' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                                                              , concat('depan', '-', 'kecil', '-', 'ganjil')
                                                                                                                                              , 'nulled'
                                                                                                                                          )
                                                                                                                                      )
                                                                                                                                  )
                                                                                                                              )
                                                                                                                          )
                                                                                                                      )
                                                                                                                  )
                                                                                                              )
                                                                                                          )
                                                                                                      )
                                                                                                  )
                                                                                              )
                                                                                              , if (
                                                                                                  togel_game.id = 13
                                                                                                  , if (
                                                                                                      bets_togel.tebak_genap_ganjil = 'genap'
                                                                                                      , 'genap'
                                                                                                      , if (
                                                                                                          bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                          , 'ganjil'
                                                                                                          , if (
                                                                                                              bets_togel.tebak_besar_kecil = 'besar'
                                                                                                              , 'besar'
                                                                                                              , if (
                                                                                                                  bets_togel.tebak_besar_kecil = 'kecil'
                                                                                                                  , 'kecil'
                                                                                                                  , 'nulled'
                                                                                                              )
                                                                                                          )
                                                                                                      )
                                                                                                  )
                                                                                                  , if (
                                                                                                      togel_game.id = 14
                                                                                                      , togel_shio_name.name
                                                                                                      , 'nulled'
                                                                                                  )
                                                                                              )
                                                                                          )
                                                                                      )
                                                                                  )
                                                                              )
                                                                          )
                                                                      )
                                                                  )
                                                              )
                                                          )
                                                      )
                                                  )
                                              )
                                          )
                                      )
                                  )
                              )
                          )
                      )
                  ) as 'Nomor'
                  , bets_togel.bet_amount as 'Bet'
                  , bets_togel.pay_amount as 'Bayar'
                  , bets_togel.win_nominal as 'winTogel'
                  , CONCAT(REPLACE(FORMAT(bets_togel.tax_amount,1),',',-1), '%') as 'disc/kei'

                  
                  , if (
                      bets_togel.number_6 is not null and bets_togel.number_5 is not null and bets_togel.number_4 is not null and bets_togel.number_3 is not null and bets_togel.number_2 is null and bets_togel.number_1 is null
                      , concat(floor(togel_setting_game.win_4d_x), 'x')
                      , if (
                          bets_togel.number_6 is not null and bets_togel.number_5 is not null and bets_togel.number_4 is not null and bets_togel.number_3 is null and bets_togel.number_2 is null and bets_togel.number_1 is null
                          , concat(floor(togel_setting_game.win_3d_x), 'x')
                          , if (
                              bets_togel.number_6 is not null and bets_togel.number_5 is not null and bets_togel.number_4 is null and bets_togel.number_3 is null and bets_togel.number_2 is null and bets_togel.number_1 is null
                              , concat(floor(togel_setting_game.win_2d_x), 'x')
                              , if (
                                  bets_togel.number_6 is null and bets_togel.number_5 is not null and bets_togel.number_4 is not null and bets_togel.number_3 is null and bets_togel.number_2 is null and bets_togel.number_1 is null
                                  , concat(floor(togel_setting_game.win_2d_tengah_x), 'x')
                                  , if (
                                      bets_togel.number_6 is null and bets_togel.number_5 is null and bets_togel.number_4 is not null and bets_togel.number_3 is not null and bets_togel.number_2 is null and bets_togel.number_1 is null
                                      , concat(floor(togel_setting_game.win_2d_depan_x), 'x')
                                      , if (
                                          togel_game.id = 5
                                          , concat(togel_setting_game.win_x, 'x')
                                          , if (
                                              togel_game.id = 6
                                              , concat(floor(togel_setting_game.win_2_digit), '/', floor(togel_setting_game.win_3_digit), '/', floor(togel_setting_game.win_4_digit), 'x')
                                              , if (
                                                  togel_game.id = 7
                                                  , concat(floor(togel_setting_game.win_3_digit), '/', floor(togel_setting_game.win_4_digit), 'x')
                                                  , if (
                                                      togel_game.id = 8
                                                      , concat(if (
                                                          bets_togel.tebak_as_kop_kepala_ekor = 'as'
                                                          , concat(floor(togel_setting_game.win_as), 'x')
                                                          , if (
                                                              bets_togel.tebak_as_kop_kepala_ekor = 'kop'
                                                              , concat(floor(togel_setting_game.win_kop), 'x')
                                                              , if (
                                                                  bets_togel.tebak_as_kop_kepala_ekor = 'kepala'
                                                                  , concat(floor(togel_setting_game.win_kepala), 'x')
                                                                  , if (
                                                                      bets_togel.tebak_as_kop_kepala_ekor = 'ekor'
                                                                      , concat(floor(togel_setting_game.win_ekor), 'x')
                                                                      , 'nulled'
                                                                  )
                                                              )
                                                          )
                                                      ))
                                                      , if (
                                                          togel_game.id = 9
                                                          , if (
                                                              bets_togel.tebak_besar_kecil is null
                                                              , if (
                                                                  bets_togel.tebak_genap_ganjil is null
                                                                  , if (
                                                                      bets_togel.tebak_tengah_tepi is null
                                                                      , 'nulled'
                                                                      , concat(floor(togel_setting_game.win_x), 'x')
                                                                  )
                                                                  , concat(floor(togel_setting_game.win_x), 'x')
                                                              )
                                                              , concat(floor(togel_setting_game.win_x), 'x')
                                                          )
                                                          , if (
                                                              togel_game.id = 10
                                                              , if (
                                                                  bets_togel.tebak_as_kop_kepala_ekor = 'as' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                  , concat(floor(togel_setting_game.win_x), 'x')
                                                                  , if (
                                                                      bets_togel.tebak_as_kop_kepala_ekor = 'as' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                      , concat(floor(togel_setting_game.win_x), 'x')
                                                                      , if (
                                                                          bets_togel.tebak_as_kop_kepala_ekor = 'kop' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                          , concat(floor(togel_setting_game.win_x), 'x')
                                                                          , if (
                                                                              bets_togel.tebak_as_kop_kepala_ekor = 'kop' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                              , concat(floor(togel_setting_game.win_x), 'x')
                                                                              , if (
                                                                                  bets_togel.tebak_as_kop_kepala_ekor = 'kepala' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                  , concat(floor(togel_setting_game.win_x), 'x')
                                                                                  , if (
                                                                                      bets_togel.tebak_as_kop_kepala_ekor = 'kepala' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                      , concat(floor(togel_setting_game.win_x), 'x')
                                                                                      , if (
                                                                                          bets_togel.tebak_as_kop_kepala_ekor = 'ekor' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                          , concat(floor(togel_setting_game.win_x), 'x')
                                                                                          , if (
                                                                                              bets_togel.tebak_as_kop_kepala_ekor = 'ekor' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                              , concat(floor(togel_setting_game.win_x), 'x')
                                                                                              , if (
                                                                                                  bets_togel.tebak_as_kop_kepala_ekor = 'as' and bets_togel.tebak_besar_kecil = 'besar'
                                                                                                  , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                  , if (
                                                                                                      bets_togel.tebak_as_kop_kepala_ekor = 'as' and bets_togel.tebak_besar_kecil = 'kecil'
                                                                                                      , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                      , if (
                                                                                                          bets_togel.tebak_as_kop_kepala_ekor = 'kop' and bets_togel.tebak_besar_kecil = 'besar'
                                                                                                          , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                          , if (
                                                                                                              bets_togel.tebak_as_kop_kepala_ekor = 'kop' and bets_togel.tebak_besar_kecil = 'kecil'
                                                                                                              , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                              , if (
                                                                                                                  bets_togel.tebak_as_kop_kepala_ekor = 'kepala' and bets_togel.tebak_besar_kecil = 'besar'
                                                                                                                  , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                                  , if (
                                                                                                                      bets_togel.tebak_as_kop_kepala_ekor = 'kepala' and bets_togel.tebak_besar_kecil = 'kecil'
                                                                                                                      , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                                      , if (
                                                                                                                          bets_togel.tebak_as_kop_kepala_ekor = 'ekor' and bets_togel.tebak_besar_kecil = 'besar'
                                                                                                                          , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                                          , if (
                                                                                                                              bets_togel.tebak_as_kop_kepala_ekor = 'ekor' and bets_togel.tebak_besar_kecil = 'kecil'
                                                                                                                              , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                                              , 'nulled'
                                                                                                                          )
                                                                                                                      )
                                                                                                                  )
                                                                                                              )
                                                                                                          )
                                                                                                      )
                                                                                                  )
                                                                                              )
                                                                                          )
                                                                                      )
                                                                                  )
                                                                              )
                                                                          )
                                                                      )
                                                                  )
                                                              )
                                                              , if (
                                                                  togel_game.id = 11
                                                                  , if (
                                                                      bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_mono_stereo = 'stereo'
                                                                      , concat(floor(togel_setting_game.win_x), 'x')
                                                                      , if (
                                                                          bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_mono_stereo = 'mono'
                                                                          , concat(floor(togel_setting_game.win_x), 'x')
                                                                          , if (
                                                                              bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_kembang_kempis_kembar = 'kembang'
                                                                              , concat(floor(togel_setting_game.win_x), 'x')
                                                                              , if (
                                                                                  bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_kembang_kempis_kembar = 'kempis'
                                                                                  , concat(floor(togel_setting_game.win_x), 'x')
                                                                                  , if (
                                                                                      bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_kembang_kempis_kembar = 'kembar'
                                                                                      , concat(floor(togel_setting_game.win_x), 'x')
                                                                                      , if (
                                                                                          bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_mono_stereo = 'stereo'
                                                                                          , concat(floor(togel_setting_game.win_x), 'x')
                                                                                          , if (
                                                                                              bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_mono_stereo = 'mono'
                                                                                              , concat(floor(togel_setting_game.win_x), 'x')
                                                                                              , if (
                                                                                                  bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_kembang_kempis_kembar = 'kembang'
                                                                                                  , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                  , if (
                                                                                                      bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_kembang_kempis_kembar = 'kempis'
                                                                                                      , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                      , if (
                                                                                                          bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_kembang_kempis_kembar = 'kembar'
                                                                                                          , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                          , if (
                                                                                                              bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_mono_stereo = 'stereo'
                                                                                                              , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                              , if (
                                                                                                                  bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_mono_stereo = 'mono'
                                                                                                                  , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                                  , if (
                                                                                                                      bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_kembang_kempis_kembar = 'kembang'
                                                                                                                      , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                                      , if (
                                                                                                                          bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_kembang_kempis_kembar = 'kempis'
                                                                                                                          , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                                          , if (
                                                                                                                              bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_kembang_kempis_kembar = 'kembar'
                                                                                                                              , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                                              , 'nulled'
                                                                                                                          )
                                                                                                                      )
                                                                                                                  )
                                                                                                              )
                                                                                                          )
                                                                                                      )
                                                                                                  )
                                                                                              )
                                                                                          )
                                                                                      )
                                                                                  )
                                                                              )
                                                                          )
                                                                      )
                                                                  )
                                                                  , if (
                                                                      togel_game.id = 12
                                                                      , if (
                                                                          bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_besar_kecil = 'besar' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                          , concat(togel_setting_game.win_x, 'x')
                                                                          , if (
                                                                              bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_besar_kecil = 'besar' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                              , concat(togel_setting_game.win_x, 'x')
                                                                              , if (
                                                                                  bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_besar_kecil = 'kecil' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                  , concat(togel_setting_game.win_x, 'x')
                                                                                  , if (
                                                                                      bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_besar_kecil = 'kecil' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                      , concat(togel_setting_game.win_x, 'x')
                                                                                      , if (
                                                                                          bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_besar_kecil = 'besar' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                          , concat(togel_setting_game.win_x, 'x')
                                                                                          , if (
                                                                                              bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_besar_kecil = 'besar' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                              , concat(togel_setting_game.win_x, 'x')
                                                                                              , if (
                                                                                                  bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_besar_kecil = 'kecil' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                                  , concat(togel_setting_game.win_x, 'x')
                                                                                                  , if (
                                                                                                      bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_besar_kecil = 'kecil' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                      , concat(togel_setting_game.win_x, 'x')
                                                                                                      , if (
                                                                                                          bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_besar_kecil = 'besar' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                                          , concat(togel_setting_game.win_x, 'x')
                                                                                                          , if (
                                                                                                              bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_besar_kecil = 'besar' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                              , concat(togel_setting_game.win_x, 'x')
                                                                                                              , if (
                                                                                                                  bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_besar_kecil = 'kecil' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                                                  , concat(togel_setting_game.win_x, 'x')
                                                                                                                  , if (
                                                                                                                      bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_besar_kecil = 'kecil' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                                      , concat(togel_setting_game.win_x, 'x')
                                                                                                                      , 'nulled'
                                                                                                                  )
                                                                                                              )
                                                                                                          )
                                                                                                      )
                                                                                                  )
                                                                                              )
                                                                                          )
                                                                                      )
                                                                                  )
                                                                              )
                                                                          )
                                                                      )
                                                                      , if (
                                                                          togel_game.id = 13
                                                                          , if (
                                                                              bets_togel.tebak_genap_ganjil = 'genap'
                                                                              , concat(floor(togel_setting_game.win_x), 'x')
                                                                              , if (
                                                                                  bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                  , concat(floor(togel_setting_game.win_x), 'x')
                                                                                  , if (
                                                                                      bets_togel.tebak_besar_kecil = 'besar'
                                                                                      , concat(floor(togel_setting_game.win_x), 'x')
                                                                                      , if (
                                                                                          bets_togel.tebak_besar_kecil = 'kecil'
                                                                                          , concat(floor(togel_setting_game.win_x), 'x')
                                                                                          , 'nulled'
                                                                                      )
                                                                                  )
                                                                              )
                                                                          )
                                                                          , if (
                                                                              togel_game.id = 14
                                                                              , concat(floor(togel_setting_game.win_x), 'x')
                                                                              , 'nulled'
                                                                          )
                                                                      )
                                                                  )
                                                              )
                                                          )
                                                      )
                                                  )
                                              )
                                          )
                                      )
                                  )
                              )
                          )
                      )
                  ) as 'Win'
                  , if (
                      bets_togel.updated_at is null
                      , 'Running'
                      , if (
                          bets_togel.win_lose_status = 1
                          , 'Win'
                          , 'Lose'
                      )
                  ) as 'Status'
              ")
              // ->where('bets_togel.updated_at', null)
              ->where('bets_togel.created_by', '=', auth('api')->user()->id)->orderBy('bets_togel.id', 'DESC')->get();
    
    return $this->togel = collect($result)->map(function ($value) {
      return [
        'created_at'    => $value->created_at,
        'bets_togel_id' => $value->id,
        'pasaran'       => $value->Pasaran,
        'description'   => 'Bet : '. $value->Game,
        'debit'     => $value->Bet, #bet
        'kredit'      => $value->winTogel, #win
        'balance'     => $value->balance,
        'created_by'    => auth('api')->user()->username,
        'url'       => "/endpoint/getDetailTransaksi?detail=$value->id",
      ];

    // $result = DB::table('bets_togel_history_transaksi as a')
    //           ->leftJoin('bets_togel as b', 'a.bets_togel_id', '=', 'b.id')
    //           ->leftJoin('constant_provider_togel as c', 'b.constant_provider_togel_id', '=', 'c.id')
    //           ->selectRaw("
    //               a.bets_togel_id,
    //               CONCAT(c.name_initial, '-', b.period) as pasaran,
    //               a.description,
    //               a.debit,
    //               a.kredit,
    //               a.balance,
    //               a.bet_id,
    //               a.created_at,
    //               a.created_by
    //           ")
    //           ->where('a.created_by', '=', auth('api')->user()->id)->orderBy('a.created_at', 'DESC')->get()->toArray();
    // return $this->togel = collect($result)->map(function ($value) {
    //   return [
    //     'created_at'    => $value->created_at,
    //     'bets_togel_id' => $value->bets_togel_id,
    //     'pasaran'       => $value->pasaran,
    //     'description'   => $value->description,
    //     'debit'     => $value->debit,
    //     'kredit'      => $value->kredit,
    //     'balance'     => $value->balance,
    //     'created_by'    => auth('api')->user()->username,
    //     'url'       => "/endpoint/getDetailTransaksi?detail=$value->bet_id",
    //   ];
    });
  }

  protected function dataTogel()
  {
    $result = BetsTogel::join('members', 'bets_togel.created_by', '=', 'members.id')  
        ->join('constant_provider_togel', 'bets_togel.constant_provider_togel_id', '=', 'constant_provider_togel.id')  
        ->join('togel_game', 'bets_togel.togel_game_id', '=', 'togel_game.id')
        ->leftJoin('togel_shio_name', 'bets_togel.tebak_shio', '=', 'togel_shio_name.id')
        ->join('togel_setting_game', 'bets_togel.togel_setting_game_id', '=', 'togel_setting_game.id')
        ->selectRaw("
            max(bets_togel.id) as id,
            bets_togel.created_by,
            min(bets_togel.balance) as balance,
            constant_provider_togel.id as constant_provider_togel_id,
            bets_togel.created_at
            
            , members.last_login_ip as 'IP'
            , members.username as 'Username'
            , concat(constant_provider_togel.name_initial, '-', bets_togel.period) as 'Pasaran'
            , if (
                bets_togel.number_6 is not null and bets_togel.number_5 is not null and bets_togel.number_4 is not null and bets_togel.number_3 is not null and bets_togel.number_2 is null and bets_togel.number_1 is null and bets_togel.togel_game_id = 1
                , '4D'
                , if (
                    bets_togel.number_6 is not null and bets_togel.number_5 is not null and bets_togel.number_4 is not null and bets_togel.number_3 is null and bets_togel.number_2 is null and bets_togel.number_1 is null and bets_togel.togel_game_id = 1 
                    , '3D'
                    , if (
                        bets_togel.number_6 is not null and bets_togel.number_5 is not null and bets_togel.number_4 is null and bets_togel.number_3 is null and bets_togel.number_2 is null and bets_togel.number_1 is null and bets_togel.togel_game_id = 1
                        , '2D'
                        , if (
                            bets_togel.number_6 is null and bets_togel.number_5 is not null and bets_togel.number_4 is not null and bets_togel.number_3 is null and bets_togel.number_2 is null and bets_togel.number_1 is null and bets_togel.togel_game_id = 1
                            , '2D Tengah'
                            , if (
                                bets_togel.number_6 is null and bets_togel.number_5 is null and bets_togel.number_4 is not null and bets_togel.number_3 is not null and bets_togel.number_2 is null and bets_togel.number_1 is null and bets_togel.togel_game_id = 1
                                , '2D Depan'
                                , togel_game.name
                            )
                        )
                    )
                )
            ) as 'Game'
            , if (
                bets_togel.number_6 is not null and bets_togel.number_5 is not null and bets_togel.number_4 is not null and bets_togel.number_3 is not null and bets_togel.number_2 is null and bets_togel.number_1 is null
                , concat(bets_togel.number_3, bets_togel.number_4, bets_togel.number_5, bets_togel.number_6)
                , if (
                    bets_togel.number_6 is not null and bets_togel.number_5 is not null and bets_togel.number_4 is not null and bets_togel.number_3 is null and bets_togel.number_2 is null and bets_togel.number_1 is null
                    , concat(bets_togel.number_4, bets_togel.number_5, bets_togel.number_6)
                    , if (
                        bets_togel.number_6 is not null and bets_togel.number_5 is not null and bets_togel.number_4 is null and bets_togel.number_3 is null and bets_togel.number_2 is null and bets_togel.number_1 is null
                        , concat(bets_togel.number_5, bets_togel.number_6)
                        , if (
                            bets_togel.number_6 is null and bets_togel.number_5 is not null and bets_togel.number_4 is not null and bets_togel.number_3 is null and bets_togel.number_2 is null and bets_togel.number_1 is null
                            , concat(bets_togel.number_4, bets_togel.number_5)
                            , if (
                                bets_togel.number_6 is null and bets_togel.number_5 is null and bets_togel.number_4 is not null and bets_togel.number_3 is not null and bets_togel.number_2 is null and bets_togel.number_1 is null
                                , concat(bets_togel.number_3, bets_togel.number_4)
                                , if (
                                    togel_game.id = 5 and bets_togel.number_3 is null and bets_togel.number_4 is null and bets_togel.number_5 is null
                                    ,bets_togel.number_6
                                    , if (
                                        togel_game.id = 5 and bets_togel.number_3 is null and bets_togel.number_4 is null and bets_togel.number_6 is null
                                        ,bets_togel.number_5
                                        , if (
                                            togel_game.id = 5 and bets_togel.number_3 is null and bets_togel.number_5 is null and bets_togel.number_6 is null
                                            ,bets_togel.number_4
                                            , if (
                                                togel_game.id = 5 and bets_togel.number_4 is null and bets_togel.number_5 is null and bets_togel.number_6 is null
                                                ,bets_togel.number_3
                                                , if (
                                                    togel_game.id = 6
                                                    , concat(bets_togel.number_1, bets_togel.number_2)
                                                    , if (
                                                        togel_game.id = 7
                                                        , concat(bets_togel.number_1, bets_togel.number_2, bets_togel.number_3)
                                                        , if (
                                                            togel_game.id = 8 and bets_togel.number_3 is null and bets_togel.number_4 is null and bets_togel.number_5 is null
                                                            , concat(bets_togel.number_6, ' - ' , bets_togel.tebak_as_kop_kepala_ekor)
                                                            , if (
                                                                togel_game.id = 8 and bets_togel.number_3 is null and bets_togel.number_4 is null and bets_togel.number_6 is null
                                                                , concat(bets_togel.number_5, ' - ' , bets_togel.tebak_as_kop_kepala_ekor)
                                                                , if (
                                                                    togel_game.id = 8 and bets_togel.number_3 is null and bets_togel.number_5 is null and bets_togel.number_6 is null
                                                                    , concat(bets_togel.number_4, ' - ' , bets_togel.tebak_as_kop_kepala_ekor)
                                                                    , if (
                                                                        togel_game.id = 8 and bets_togel.number_4 is null and bets_togel.number_5 is null and bets_togel.number_6 is null
                                                                        , concat(bets_togel.number_3, ' - ' , bets_togel.tebak_as_kop_kepala_ekor)
                                                                        , if (
                                                                            togel_game.id = 9
                                                                            , if (
                                                                                bets_togel.tebak_besar_kecil is null
                                                                                , if (
                                                                                    bets_togel.tebak_genap_ganjil is null
                                                                                    , if (
                                                                                        bets_togel.tebak_tengah_tepi is null
                                                                                        , 'nulled'
                                                                                        , bets_togel.tebak_tengah_tepi
                                                                                    )
                                                                                    , bets_togel.tebak_genap_ganjil
                                                                                )
                                                                                , bets_togel.tebak_besar_kecil
                                                                            )
                                                                            , if (
                                                                                togel_game.id = 10
                                                                                , if (
                                                                                    bets_togel.tebak_as_kop_kepala_ekor = 'as' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                    , concat('as', '-', 'genap')
                                                                                    , if (
                                                                                        bets_togel.tebak_as_kop_kepala_ekor = 'as' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                        , concat('as', '-', 'ganjil')
                                                                                        , if (
                                                                                            bets_togel.tebak_as_kop_kepala_ekor = 'kop' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                            , concat('kop', '-', 'genap')
                                                                                            , if (
                                                                                                bets_togel.tebak_as_kop_kepala_ekor = 'kop' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                , concat('kop', '-', 'ganjil')
                                                                                                , if (
                                                                                                    bets_togel.tebak_as_kop_kepala_ekor = 'kepala' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                                    , concat('kepala', '-', 'genap')
                                                                                                    , if (
                                                                                                        bets_togel.tebak_as_kop_kepala_ekor = 'kepala' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                        , concat('kepala', '-', 'ganjil')
                                                                                                        , if (
                                                                                                            bets_togel.tebak_as_kop_kepala_ekor = 'ekor' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                                            , concat('ekor', '-', 'genap')
                                                                                                            , if (
                                                                                                                bets_togel.tebak_as_kop_kepala_ekor = 'ekor' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                                , concat('ekor', '-', 'ganjil')
                                                                                                                , if (
                                                                                                                    bets_togel.tebak_as_kop_kepala_ekor = 'as' and bets_togel.tebak_besar_kecil = 'besar'
                                                                                                                    , concat('as', '-', 'besar')
                                                                                                                    , if (
                                                                                                                        bets_togel.tebak_as_kop_kepala_ekor = 'as' and bets_togel.tebak_besar_kecil = 'kecil'
                                                                                                                        , concat('as', '-', 'kecil')
                                                                                                                        , if (
                                                                                                                            bets_togel.tebak_as_kop_kepala_ekor = 'kop' and bets_togel.tebak_besar_kecil = 'besar'
                                                                                                                            , concat('kop', '-', 'besar')
                                                                                                                            , if (
                                                                                                                                bets_togel.tebak_as_kop_kepala_ekor = 'kop' and bets_togel.tebak_besar_kecil = 'kecil'
                                                                                                                                , concat('kop', '-', 'kecil')
                                                                                                                                , if (
                                                                                                                                    bets_togel.tebak_as_kop_kepala_ekor = 'kepala' and bets_togel.tebak_besar_kecil = 'besar'
                                                                                                                                    , concat('kepala', '-', 'besar')
                                                                                                                                    , if (
                                                                                                                                        bets_togel.tebak_as_kop_kepala_ekor = 'kepala' and bets_togel.tebak_besar_kecil = 'kecil'
                                                                                                                                        , concat('kepala', '-', 'kecil')
                                                                                                                                        , if (
                                                                                                                                            bets_togel.tebak_as_kop_kepala_ekor = 'ekor' and bets_togel.tebak_besar_kecil = 'besar'
                                                                                                                                            , concat('ekor', '-', 'besar')
                                                                                                                                            , if (
                                                                                                                                                bets_togel.tebak_as_kop_kepala_ekor = 'ekor' and bets_togel.tebak_besar_kecil = 'kecil'
                                                                                                                                                , concat('ekor', '-', 'kecil')
                                                                                                                                                , 'nulled'
                                                                                                                                            )
                                                                                                                                        )
                                                                                                                                    )
                                                                                                                                )
                                                                                                                            )
                                                                                                                        )
                                                                                                                    )
                                                                                                                )
                                                                                                            )
                                                                                                        )
                                                                                                    )
                                                                                                )
                                                                                            )
                                                                                        )
                                                                                    )
                                                                                )
                                                                                , if (
                                                                                    togel_game.id = 11
                                                                                    , if (
                                                                                        bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_mono_stereo = 'stereo'
                                                                                        , concat('belakang', ' - ', 'stereo')
                                                                                        , if (
                                                                                            bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_mono_stereo = 'mono'
                                                                                            , concat('belakang', ' - ', 'mono')
                                                                                            , if (
                                                                                                bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_kembang_kempis_kembar = 'kembang'
                                                                                                , concat('belakang', ' - ', 'kembang')
                                                                                                , if (
                                                                                                    bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_kembang_kempis_kembar = 'kempis'
                                                                                                    , concat('belakang', ' - ', 'kempis')
                                                                                                    , if (
                                                                                                        bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_kembang_kempis_kembar = 'kembar'
                                                                                                        , concat('belakang', ' - ', 'kembar')
                                                                                                        , if (
                                                                                                            bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_mono_stereo = 'stereo'
                                                                                                            , concat('tengah', ' - ', 'stereo')
                                                                                                            , if (
                                                                                                                bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_mono_stereo = 'mono'
                                                                                                                , concat('tengah', ' - ', 'mono')
                                                                                                                , if (
                                                                                                                    bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_kembang_kempis_kembar = 'kembang'
                                                                                                                    , concat('tengah', ' - ', 'kembang')
                                                                                                                    , if (
                                                                                                                        bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_kembang_kempis_kembar = 'kempis'
                                                                                                                        , concat('tengah', ' - ', 'kempis')
                                                                                                                        , if (
                                                                                                                            bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_kembang_kempis_kembar = 'kembar'
                                                                                                                            , concat('tengah', ' - ', 'kembar')
                                                                                                                            , if (
                                                                                                                                bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_mono_stereo = 'stereo'
                                                                                                                                , concat('depan', ' - ', 'stereo')
                                                                                                                                , if (
                                                                                                                                    bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_mono_stereo = 'mono'
                                                                                                                                    , concat('depan', ' - ', 'mono')
                                                                                                                                    , if (
                                                                                                                                        bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_kembang_kempis_kembar = 'kembang'
                                                                                                                                        , concat('depan', ' - ', 'kembang')
                                                                                                                                        , if (
                                                                                                                                            bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_kembang_kempis_kembar = 'kempis'
                                                                                                                                            , concat('depan', ' - ', 'kempis')
                                                                                                                                            , if (
                                                                                                                                                bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_kembang_kempis_kembar = 'kembar'
                                                                                                                                                , concat('depan', ' - ', 'kembar')
                                                                                                                                                , 'nulled'
                                                                                                                                            )
                                                                                                                                        )
                                                                                                                                    )
                                                                                                                                )
                                                                                                                            )
                                                                                                                        )
                                                                                                                    )
                                                                                                                )
                                                                                                            )
                                                                                                        )
                                                                                                    )
                                                                                                )
                                                                                            )
                                                                                        )
                                                                                    )
                                                                                    , if (
                                                                                        togel_game.id = 12
                                                                                        , if (
                                                                                            bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_besar_kecil = 'besar' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                            , concat('belakang', '-', 'besar', '-', 'genap')
                                                                                            , if (
                                                                                                bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_besar_kecil = 'besar' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                , concat('belakang', '-', 'besar', '-', 'ganjil')
                                                                                                , if (
                                                                                                    bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_besar_kecil = 'kecil' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                                    , concat('belakang', '-', 'kecil', '-', 'genap')
                                                                                                    , if (
                                                                                                        bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_besar_kecil = 'kecil' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                        , concat('belakang', '-', 'kecil', '-', 'ganjil')
                                                                                                        , if (
                                                                                                            bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_besar_kecil = 'besar' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                                            , concat('tengah', '-', 'besar', '-', 'genap')
                                                                                                            , if (
                                                                                                                bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_besar_kecil = 'besar' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                                , concat('tengah', '-', 'besar', '-', 'ganjil')
                                                                                                                , if (
                                                                                                                    bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_besar_kecil = 'kecil' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                                                    , concat('tengah', '-', 'kecil', '-', 'genap')
                                                                                                                    , if (
                                                                                                                        bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_besar_kecil = 'kecil' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                                        , concat('tengah', '-', 'kecil', '-', 'ganjil')
                                                                                                                        , if (
                                                                                                                            bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_besar_kecil = 'besar' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                                                            , concat('depan', '-', 'besar', '-', 'genap')
                                                                                                                            , if (
                                                                                                                                bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_besar_kecil = 'besar' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                                                , concat('depan', '-', 'besar', '-', 'ganjil')
                                                                                                                                , if (
                                                                                                                                    bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_besar_kecil = 'kecil' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                                                                    , concat('depan', '-', 'kecil', '-', 'genap')
                                                                                                                                    , if (
                                                                                                                                        bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_besar_kecil = 'kecil' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                                                        , concat('depan', '-', 'kecil', '-', 'ganjil')
                                                                                                                                        , 'nulled'
                                                                                                                                    )
                                                                                                                                )
                                                                                                                            )
                                                                                                                        )
                                                                                                                    )
                                                                                                                )
                                                                                                            )
                                                                                                        )
                                                                                                    )
                                                                                                )
                                                                                            )
                                                                                        )
                                                                                        , if (
                                                                                            togel_game.id = 13
                                                                                            , if (
                                                                                                bets_togel.tebak_genap_ganjil = 'genap'
                                                                                                , 'genap'
                                                                                                , if (
                                                                                                    bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                    , 'ganjil'
                                                                                                    , if (
                                                                                                        bets_togel.tebak_besar_kecil = 'besar'
                                                                                                        , 'besar'
                                                                                                        , if (
                                                                                                            bets_togel.tebak_besar_kecil = 'kecil'
                                                                                                            , 'kecil'
                                                                                                            , 'nulled'
                                                                                                        )
                                                                                                    )
                                                                                                )
                                                                                            )
                                                                                            , if (
                                                                                                togel_game.id = 14
                                                                                                , togel_shio_name.name
                                                                                                , 'nulled'
                                                                                            )
                                                                                        )
                                                                                    )
                                                                                )
                                                                            )
                                                                        )
                                                                    )
                                                                )
                                                            )
                                                        )
                                                    )
                                                )
                                            )
                                        )
                                    )
                                )
                            )
                        )
                    )
                )
            ) as 'Nomor'
            , bets_togel.bet_amount as 'Bet'
            , bets_togel.pay_amount as 'Bayar'
            , bets_togel.win_nominal as 'winTogel'
            , CONCAT(REPLACE(FORMAT(bets_togel.tax_amount,1),',',-1), '%') as 'disc/kei'

            
            , if (
                bets_togel.number_6 is not null and bets_togel.number_5 is not null and bets_togel.number_4 is not null and bets_togel.number_3 is not null and bets_togel.number_2 is null and bets_togel.number_1 is null
                , concat(floor(togel_setting_game.win_4d_x), 'x')
                , if (
                    bets_togel.number_6 is not null and bets_togel.number_5 is not null and bets_togel.number_4 is not null and bets_togel.number_3 is null and bets_togel.number_2 is null and bets_togel.number_1 is null
                    , concat(floor(togel_setting_game.win_3d_x), 'x')
                    , if (
                        bets_togel.number_6 is not null and bets_togel.number_5 is not null and bets_togel.number_4 is null and bets_togel.number_3 is null and bets_togel.number_2 is null and bets_togel.number_1 is null
                        , concat(floor(togel_setting_game.win_2d_x), 'x')
                        , if (
                            bets_togel.number_6 is null and bets_togel.number_5 is not null and bets_togel.number_4 is not null and bets_togel.number_3 is null and bets_togel.number_2 is null and bets_togel.number_1 is null
                            , concat(floor(togel_setting_game.win_2d_tengah_x), 'x')
                            , if (
                                bets_togel.number_6 is null and bets_togel.number_5 is null and bets_togel.number_4 is not null and bets_togel.number_3 is not null and bets_togel.number_2 is null and bets_togel.number_1 is null
                                , concat(floor(togel_setting_game.win_2d_depan_x), 'x')
                                , if (
                                    togel_game.id = 5
                                    , concat(togel_setting_game.win_x, 'x')
                                    , if (
                                        togel_game.id = 6
                                        , concat(floor(togel_setting_game.win_2_digit), '/', floor(togel_setting_game.win_3_digit), '/', floor(togel_setting_game.win_4_digit), 'x')
                                        , if (
                                            togel_game.id = 7
                                            , concat(floor(togel_setting_game.win_3_digit), '/', floor(togel_setting_game.win_4_digit), 'x')
                                            , if (
                                                togel_game.id = 8
                                                , concat(if (
                                                    bets_togel.tebak_as_kop_kepala_ekor = 'as'
                                                    , concat(floor(togel_setting_game.win_as), 'x')
                                                    , if (
                                                        bets_togel.tebak_as_kop_kepala_ekor = 'kop'
                                                        , concat(floor(togel_setting_game.win_kop), 'x')
                                                        , if (
                                                            bets_togel.tebak_as_kop_kepala_ekor = 'kepala'
                                                            , concat(floor(togel_setting_game.win_kepala), 'x')
                                                            , if (
                                                                bets_togel.tebak_as_kop_kepala_ekor = 'ekor'
                                                                , concat(floor(togel_setting_game.win_ekor), 'x')
                                                                , 'nulled'
                                                            )
                                                        )
                                                    )
                                                ))
                                                , if (
                                                    togel_game.id = 9
                                                    , if (
                                                        bets_togel.tebak_besar_kecil is null
                                                        , if (
                                                            bets_togel.tebak_genap_ganjil is null
                                                            , if (
                                                                bets_togel.tebak_tengah_tepi is null
                                                                , 'nulled'
                                                                , concat(floor(togel_setting_game.win_x), 'x')
                                                            )
                                                            , concat(floor(togel_setting_game.win_x), 'x')
                                                        )
                                                        , concat(floor(togel_setting_game.win_x), 'x')
                                                    )
                                                    , if (
                                                        togel_game.id = 10
                                                        , if (
                                                            bets_togel.tebak_as_kop_kepala_ekor = 'as' and bets_togel.tebak_genap_ganjil = 'genap'
                                                            , concat(floor(togel_setting_game.win_x), 'x')
                                                            , if (
                                                                bets_togel.tebak_as_kop_kepala_ekor = 'as' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                , concat(floor(togel_setting_game.win_x), 'x')
                                                                , if (
                                                                    bets_togel.tebak_as_kop_kepala_ekor = 'kop' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                    , concat(floor(togel_setting_game.win_x), 'x')
                                                                    , if (
                                                                        bets_togel.tebak_as_kop_kepala_ekor = 'kop' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                        , concat(floor(togel_setting_game.win_x), 'x')
                                                                        , if (
                                                                            bets_togel.tebak_as_kop_kepala_ekor = 'kepala' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                            , concat(floor(togel_setting_game.win_x), 'x')
                                                                            , if (
                                                                                bets_togel.tebak_as_kop_kepala_ekor = 'kepala' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                , concat(floor(togel_setting_game.win_x), 'x')
                                                                                , if (
                                                                                    bets_togel.tebak_as_kop_kepala_ekor = 'ekor' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                    , concat(floor(togel_setting_game.win_x), 'x')
                                                                                    , if (
                                                                                        bets_togel.tebak_as_kop_kepala_ekor = 'ekor' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                        , concat(floor(togel_setting_game.win_x), 'x')
                                                                                        , if (
                                                                                            bets_togel.tebak_as_kop_kepala_ekor = 'as' and bets_togel.tebak_besar_kecil = 'besar'
                                                                                            , concat(floor(togel_setting_game.win_x), 'x')
                                                                                            , if (
                                                                                                bets_togel.tebak_as_kop_kepala_ekor = 'as' and bets_togel.tebak_besar_kecil = 'kecil'
                                                                                                , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                , if (
                                                                                                    bets_togel.tebak_as_kop_kepala_ekor = 'kop' and bets_togel.tebak_besar_kecil = 'besar'
                                                                                                    , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                    , if (
                                                                                                        bets_togel.tebak_as_kop_kepala_ekor = 'kop' and bets_togel.tebak_besar_kecil = 'kecil'
                                                                                                        , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                        , if (
                                                                                                            bets_togel.tebak_as_kop_kepala_ekor = 'kepala' and bets_togel.tebak_besar_kecil = 'besar'
                                                                                                            , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                            , if (
                                                                                                                bets_togel.tebak_as_kop_kepala_ekor = 'kepala' and bets_togel.tebak_besar_kecil = 'kecil'
                                                                                                                , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                                , if (
                                                                                                                    bets_togel.tebak_as_kop_kepala_ekor = 'ekor' and bets_togel.tebak_besar_kecil = 'besar'
                                                                                                                    , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                                    , if (
                                                                                                                        bets_togel.tebak_as_kop_kepala_ekor = 'ekor' and bets_togel.tebak_besar_kecil = 'kecil'
                                                                                                                        , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                                        , 'nulled'
                                                                                                                    )
                                                                                                                )
                                                                                                            )
                                                                                                        )
                                                                                                    )
                                                                                                )
                                                                                            )
                                                                                        )
                                                                                    )
                                                                                )
                                                                            )
                                                                        )
                                                                    )
                                                                )
                                                            )
                                                        )
                                                        , if (
                                                            togel_game.id = 11
                                                            , if (
                                                                bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_mono_stereo = 'stereo'
                                                                , concat(floor(togel_setting_game.win_x), 'x')
                                                                , if (
                                                                    bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_mono_stereo = 'mono'
                                                                    , concat(floor(togel_setting_game.win_x), 'x')
                                                                    , if (
                                                                        bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_kembang_kempis_kembar = 'kembang'
                                                                        , concat(floor(togel_setting_game.win_x), 'x')
                                                                        , if (
                                                                            bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_kembang_kempis_kembar = 'kempis'
                                                                            , concat(floor(togel_setting_game.win_x), 'x')
                                                                            , if (
                                                                                bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_kembang_kempis_kembar = 'kembar'
                                                                                , concat(floor(togel_setting_game.win_x), 'x')
                                                                                , if (
                                                                                    bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_mono_stereo = 'stereo'
                                                                                    , concat(floor(togel_setting_game.win_x), 'x')
                                                                                    , if (
                                                                                        bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_mono_stereo = 'mono'
                                                                                        , concat(floor(togel_setting_game.win_x), 'x')
                                                                                        , if (
                                                                                            bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_kembang_kempis_kembar = 'kembang'
                                                                                            , concat(floor(togel_setting_game.win_x), 'x')
                                                                                            , if (
                                                                                                bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_kembang_kempis_kembar = 'kempis'
                                                                                                , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                , if (
                                                                                                    bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_kembang_kempis_kembar = 'kembar'
                                                                                                    , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                    , if (
                                                                                                        bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_mono_stereo = 'stereo'
                                                                                                        , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                        , if (
                                                                                                            bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_mono_stereo = 'mono'
                                                                                                            , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                            , if (
                                                                                                                bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_kembang_kempis_kembar = 'kembang'
                                                                                                                , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                                , if (
                                                                                                                    bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_kembang_kempis_kembar = 'kempis'
                                                                                                                    , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                                    , if (
                                                                                                                        bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_kembang_kempis_kembar = 'kembar'
                                                                                                                        , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                                        , 'nulled'
                                                                                                                    )
                                                                                                                )
                                                                                                            )
                                                                                                        )
                                                                                                    )
                                                                                                )
                                                                                            )
                                                                                        )
                                                                                    )
                                                                                )
                                                                            )
                                                                        )
                                                                    )
                                                                )
                                                            )
                                                            , if (
                                                                togel_game.id = 12
                                                                , if (
                                                                    bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_besar_kecil = 'besar' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                    , concat(togel_setting_game.win_x, 'x')
                                                                    , if (
                                                                        bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_besar_kecil = 'besar' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                        , concat(togel_setting_game.win_x, 'x')
                                                                        , if (
                                                                            bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_besar_kecil = 'kecil' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                            , concat(togel_setting_game.win_x, 'x')
                                                                            , if (
                                                                                bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_besar_kecil = 'kecil' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                , concat(togel_setting_game.win_x, 'x')
                                                                                , if (
                                                                                    bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_besar_kecil = 'besar' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                    , concat(togel_setting_game.win_x, 'x')
                                                                                    , if (
                                                                                        bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_besar_kecil = 'besar' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                        , concat(togel_setting_game.win_x, 'x')
                                                                                        , if (
                                                                                            bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_besar_kecil = 'kecil' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                            , concat(togel_setting_game.win_x, 'x')
                                                                                            , if (
                                                                                                bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_besar_kecil = 'kecil' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                , concat(togel_setting_game.win_x, 'x')
                                                                                                , if (
                                                                                                    bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_besar_kecil = 'besar' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                                    , concat(togel_setting_game.win_x, 'x')
                                                                                                    , if (
                                                                                                        bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_besar_kecil = 'besar' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                        , concat(togel_setting_game.win_x, 'x')
                                                                                                        , if (
                                                                                                            bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_besar_kecil = 'kecil' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                                            , concat(togel_setting_game.win_x, 'x')
                                                                                                            , if (
                                                                                                                bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_besar_kecil = 'kecil' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                                , concat(togel_setting_game.win_x, 'x')
                                                                                                                , 'nulled'
                                                                                                            )
                                                                                                        )
                                                                                                    )
                                                                                                )
                                                                                            )
                                                                                        )
                                                                                    )
                                                                                )
                                                                            )
                                                                        )
                                                                    )
                                                                )
                                                                , if (
                                                                    togel_game.id = 13
                                                                    , if (
                                                                        bets_togel.tebak_genap_ganjil = 'genap'
                                                                        , concat(floor(togel_setting_game.win_x), 'x')
                                                                        , if (
                                                                            bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                            , concat(floor(togel_setting_game.win_x), 'x')
                                                                            , if (
                                                                                bets_togel.tebak_besar_kecil = 'besar'
                                                                                , concat(floor(togel_setting_game.win_x), 'x')
                                                                                , if (
                                                                                    bets_togel.tebak_besar_kecil = 'kecil'
                                                                                    , concat(floor(togel_setting_game.win_x), 'x')
                                                                                    , 'nulled'
                                                                                )
                                                                            )
                                                                        )
                                                                    )
                                                                    , if (
                                                                        togel_game.id = 14
                                                                        , concat(floor(togel_setting_game.win_x), 'x')
                                                                        , 'nulled'
                                                                    )
                                                                )
                                                            )
                                                        )
                                                    )
                                                )
                                            )
                                        )
                                    )
                                )
                            )
                        )
                    )
                )
            ) as 'Win'
            , if (
                bets_togel.updated_at is null
                , 'Running'
                , if (
                    bets_togel.win_lose_status = 1
                    , 'Win'
                    , 'Lose'
                )
            ) as 'Status'
        ")
        // ->where('bets_togel.updated_at', null)
        ->where('bets_togel.created_by', '=', auth('api')->user()->id)
        ->orderBy('bets_togel.id', 'DESC')
        ->groupBy('bets_togel.togel_game_id')
        ->groupBy(DB::raw("DATE_FORMAT(bets_togel.created_at, '%Y-%m-%d %H:%i')"))
        ->get();
    return $result;          
  }

  protected function detailDataTogel($id)
  {
    $date = BetsTogel::find($id);
    $result = BetsTogel::join('members', 'bets_togel.created_by', '=', 'members.id')  
            ->join('constant_provider_togel', 'bets_togel.constant_provider_togel_id', '=', 'constant_provider_togel.id')  
            ->join('togel_game', 'bets_togel.togel_game_id', '=', 'togel_game.id')
            ->leftJoin('togel_shio_name', 'bets_togel.tebak_shio', '=', 'togel_shio_name.id')
            ->join('togel_setting_game', 'bets_togel.togel_setting_game_id', '=', 'togel_setting_game.id')
            ->selectRaw("
                bets_togel.id,
                bets_togel.balance,
                constant_provider_togel.id as constant_provider_togel_id,
                bets_togel.created_at
                
                , members.last_login_ip as 'IP'
                , members.username as 'Username'
                , concat(constant_provider_togel.name_initial, '-', bets_togel.period) as 'Pasaran'
                , if (
                    bets_togel.number_6 is not null and bets_togel.number_5 is not null and bets_togel.number_4 is not null and bets_togel.number_3 is not null and bets_togel.number_2 is null and bets_togel.number_1 is null and bets_togel.togel_game_id = 1
                    , '4D'
                    , if (
                        bets_togel.number_6 is not null and bets_togel.number_5 is not null and bets_togel.number_4 is not null and bets_togel.number_3 is null and bets_togel.number_2 is null and bets_togel.number_1 is null and bets_togel.togel_game_id = 1 
                        , '3D'
                        , if (
                            bets_togel.number_6 is not null and bets_togel.number_5 is not null and bets_togel.number_4 is null and bets_togel.number_3 is null and bets_togel.number_2 is null and bets_togel.number_1 is null and bets_togel.togel_game_id = 1
                            , '2D'
                            , if (
                                bets_togel.number_6 is null and bets_togel.number_5 is not null and bets_togel.number_4 is not null and bets_togel.number_3 is null and bets_togel.number_2 is null and bets_togel.number_1 is null and bets_togel.togel_game_id = 1
                                , '2D Tengah'
                                , if (
                                    bets_togel.number_6 is null and bets_togel.number_5 is null and bets_togel.number_4 is not null and bets_togel.number_3 is not null and bets_togel.number_2 is null and bets_togel.number_1 is null and bets_togel.togel_game_id = 1
                                    , '2D Depan'
                                    , togel_game.name
                                )
                            )
                        )
                    )
                ) as 'Game'
                , if (
                    bets_togel.number_6 is not null and bets_togel.number_5 is not null and bets_togel.number_4 is not null and bets_togel.number_3 is not null and bets_togel.number_2 is null and bets_togel.number_1 is null
                    , concat(bets_togel.number_3, bets_togel.number_4, bets_togel.number_5, bets_togel.number_6)
                    , if (
                        bets_togel.number_6 is not null and bets_togel.number_5 is not null and bets_togel.number_4 is not null and bets_togel.number_3 is null and bets_togel.number_2 is null and bets_togel.number_1 is null
                        , concat(bets_togel.number_4, bets_togel.number_5, bets_togel.number_6)
                        , if (
                            bets_togel.number_6 is not null and bets_togel.number_5 is not null and bets_togel.number_4 is null and bets_togel.number_3 is null and bets_togel.number_2 is null and bets_togel.number_1 is null
                            , concat(bets_togel.number_5, bets_togel.number_6)
                            , if (
                                bets_togel.number_6 is null and bets_togel.number_5 is not null and bets_togel.number_4 is not null and bets_togel.number_3 is null and bets_togel.number_2 is null and bets_togel.number_1 is null
                                , concat(bets_togel.number_4, bets_togel.number_5)
                                , if (
                                    bets_togel.number_6 is null and bets_togel.number_5 is null and bets_togel.number_4 is not null and bets_togel.number_3 is not null and bets_togel.number_2 is null and bets_togel.number_1 is null
                                    , concat(bets_togel.number_3, bets_togel.number_4)
                                    , if (
                                        togel_game.id = 5 and bets_togel.number_3 is null and bets_togel.number_4 is null and bets_togel.number_5 is null
                                        ,bets_togel.number_6
                                        , if (
                                            togel_game.id = 5 and bets_togel.number_3 is null and bets_togel.number_4 is null and bets_togel.number_6 is null
                                            ,bets_togel.number_5
                                            , if (
                                                togel_game.id = 5 and bets_togel.number_3 is null and bets_togel.number_5 is null and bets_togel.number_6 is null
                                                ,bets_togel.number_4
                                                , if (
                                                    togel_game.id = 5 and bets_togel.number_4 is null and bets_togel.number_5 is null and bets_togel.number_6 is null
                                                    ,bets_togel.number_3
                                                    , if (
                                                        togel_game.id = 6
                                                        , concat(bets_togel.number_1, bets_togel.number_2)
                                                        , if (
                                                            togel_game.id = 7
                                                            , concat(bets_togel.number_1, bets_togel.number_2, bets_togel.number_3)
                                                            , if (
                                                                togel_game.id = 8 and bets_togel.number_3 is null and bets_togel.number_4 is null and bets_togel.number_5 is null
                                                                , concat(bets_togel.number_6, ' - ' , bets_togel.tebak_as_kop_kepala_ekor)
                                                                , if (
                                                                    togel_game.id = 8 and bets_togel.number_3 is null and bets_togel.number_4 is null and bets_togel.number_6 is null
                                                                    , concat(bets_togel.number_5, ' - ' , bets_togel.tebak_as_kop_kepala_ekor)
                                                                    , if (
                                                                        togel_game.id = 8 and bets_togel.number_3 is null and bets_togel.number_5 is null and bets_togel.number_6 is null
                                                                        , concat(bets_togel.number_4, ' - ' , bets_togel.tebak_as_kop_kepala_ekor)
                                                                        , if (
                                                                            togel_game.id = 8 and bets_togel.number_4 is null and bets_togel.number_5 is null and bets_togel.number_6 is null
                                                                            , concat(bets_togel.number_3, ' - ' , bets_togel.tebak_as_kop_kepala_ekor)
                                                                            , if (
                                                                                togel_game.id = 9
                                                                                , if (
                                                                                    bets_togel.tebak_besar_kecil is null
                                                                                    , if (
                                                                                        bets_togel.tebak_genap_ganjil is null
                                                                                        , if (
                                                                                            bets_togel.tebak_tengah_tepi is null
                                                                                            , 'nulled'
                                                                                            , bets_togel.tebak_tengah_tepi
                                                                                        )
                                                                                        , bets_togel.tebak_genap_ganjil
                                                                                    )
                                                                                    , bets_togel.tebak_besar_kecil
                                                                                )
                                                                                , if (
                                                                                    togel_game.id = 10
                                                                                    , if (
                                                                                        bets_togel.tebak_as_kop_kepala_ekor = 'as' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                        , concat('as', '-', 'genap')
                                                                                        , if (
                                                                                            bets_togel.tebak_as_kop_kepala_ekor = 'as' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                            , concat('as', '-', 'ganjil')
                                                                                            , if (
                                                                                                bets_togel.tebak_as_kop_kepala_ekor = 'kop' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                                , concat('kop', '-', 'genap')
                                                                                                , if (
                                                                                                    bets_togel.tebak_as_kop_kepala_ekor = 'kop' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                    , concat('kop', '-', 'ganjil')
                                                                                                    , if (
                                                                                                        bets_togel.tebak_as_kop_kepala_ekor = 'kepala' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                                        , concat('kepala', '-', 'genap')
                                                                                                        , if (
                                                                                                            bets_togel.tebak_as_kop_kepala_ekor = 'kepala' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                            , concat('kepala', '-', 'ganjil')
                                                                                                            , if (
                                                                                                                bets_togel.tebak_as_kop_kepala_ekor = 'ekor' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                                                , concat('ekor', '-', 'genap')
                                                                                                                , if (
                                                                                                                    bets_togel.tebak_as_kop_kepala_ekor = 'ekor' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                                    , concat('ekor', '-', 'ganjil')
                                                                                                                    , if (
                                                                                                                        bets_togel.tebak_as_kop_kepala_ekor = 'as' and bets_togel.tebak_besar_kecil = 'besar'
                                                                                                                        , concat('as', '-', 'besar')
                                                                                                                        , if (
                                                                                                                            bets_togel.tebak_as_kop_kepala_ekor = 'as' and bets_togel.tebak_besar_kecil = 'kecil'
                                                                                                                            , concat('as', '-', 'kecil')
                                                                                                                            , if (
                                                                                                                                bets_togel.tebak_as_kop_kepala_ekor = 'kop' and bets_togel.tebak_besar_kecil = 'besar'
                                                                                                                                , concat('kop', '-', 'besar')
                                                                                                                                , if (
                                                                                                                                    bets_togel.tebak_as_kop_kepala_ekor = 'kop' and bets_togel.tebak_besar_kecil = 'kecil'
                                                                                                                                    , concat('kop', '-', 'kecil')
                                                                                                                                    , if (
                                                                                                                                        bets_togel.tebak_as_kop_kepala_ekor = 'kepala' and bets_togel.tebak_besar_kecil = 'besar'
                                                                                                                                        , concat('kepala', '-', 'besar')
                                                                                                                                        , if (
                                                                                                                                            bets_togel.tebak_as_kop_kepala_ekor = 'kepala' and bets_togel.tebak_besar_kecil = 'kecil'
                                                                                                                                            , concat('kepala', '-', 'kecil')
                                                                                                                                            , if (
                                                                                                                                                bets_togel.tebak_as_kop_kepala_ekor = 'ekor' and bets_togel.tebak_besar_kecil = 'besar'
                                                                                                                                                , concat('ekor', '-', 'besar')
                                                                                                                                                , if (
                                                                                                                                                    bets_togel.tebak_as_kop_kepala_ekor = 'ekor' and bets_togel.tebak_besar_kecil = 'kecil'
                                                                                                                                                    , concat('ekor', '-', 'kecil')
                                                                                                                                                    , 'nulled'
                                                                                                                                                )
                                                                                                                                            )
                                                                                                                                        )
                                                                                                                                    )
                                                                                                                                )
                                                                                                                            )
                                                                                                                        )
                                                                                                                    )
                                                                                                                )
                                                                                                            )
                                                                                                        )
                                                                                                    )
                                                                                                )
                                                                                            )
                                                                                        )
                                                                                    )
                                                                                    , if (
                                                                                        togel_game.id = 11
                                                                                        , if (
                                                                                            bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_mono_stereo = 'stereo'
                                                                                            , concat('belakang', ' - ', 'stereo')
                                                                                            , if (
                                                                                                bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_mono_stereo = 'mono'
                                                                                                , concat('belakang', ' - ', 'mono')
                                                                                                , if (
                                                                                                    bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_kembang_kempis_kembar = 'kembang'
                                                                                                    , concat('belakang', ' - ', 'kembang')
                                                                                                    , if (
                                                                                                        bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_kembang_kempis_kembar = 'kempis'
                                                                                                        , concat('belakang', ' - ', 'kempis')
                                                                                                        , if (
                                                                                                            bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_kembang_kempis_kembar = 'kembar'
                                                                                                            , concat('belakang', ' - ', 'kembar')
                                                                                                            , if (
                                                                                                                bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_mono_stereo = 'stereo'
                                                                                                                , concat('tengah', ' - ', 'stereo')
                                                                                                                , if (
                                                                                                                    bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_mono_stereo = 'mono'
                                                                                                                    , concat('tengah', ' - ', 'mono')
                                                                                                                    , if (
                                                                                                                        bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_kembang_kempis_kembar = 'kembang'
                                                                                                                        , concat('tengah', ' - ', 'kembang')
                                                                                                                        , if (
                                                                                                                            bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_kembang_kempis_kembar = 'kempis'
                                                                                                                            , concat('tengah', ' - ', 'kempis')
                                                                                                                            , if (
                                                                                                                                bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_kembang_kempis_kembar = 'kembar'
                                                                                                                                , concat('tengah', ' - ', 'kembar')
                                                                                                                                , if (
                                                                                                                                    bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_mono_stereo = 'stereo'
                                                                                                                                    , concat('depan', ' - ', 'stereo')
                                                                                                                                    , if (
                                                                                                                                        bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_mono_stereo = 'mono'
                                                                                                                                        , concat('depan', ' - ', 'mono')
                                                                                                                                        , if (
                                                                                                                                            bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_kembang_kempis_kembar = 'kembang'
                                                                                                                                            , concat('depan', ' - ', 'kembang')
                                                                                                                                            , if (
                                                                                                                                                bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_kembang_kempis_kembar = 'kempis'
                                                                                                                                                , concat('depan', ' - ', 'kempis')
                                                                                                                                                , if (
                                                                                                                                                    bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_kembang_kempis_kembar = 'kembar'
                                                                                                                                                    , concat('depan', ' - ', 'kembar')
                                                                                                                                                    , 'nulled'
                                                                                                                                                )
                                                                                                                                            )
                                                                                                                                        )
                                                                                                                                    )
                                                                                                                                )
                                                                                                                            )
                                                                                                                        )
                                                                                                                    )
                                                                                                                )
                                                                                                            )
                                                                                                        )
                                                                                                    )
                                                                                                )
                                                                                            )
                                                                                        )
                                                                                        , if (
                                                                                            togel_game.id = 12
                                                                                            , if (
                                                                                                bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_besar_kecil = 'besar' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                                , concat('belakang', '-', 'besar', '-', 'genap')
                                                                                                , if (
                                                                                                    bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_besar_kecil = 'besar' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                    , concat('belakang', '-', 'besar', '-', 'ganjil')
                                                                                                    , if (
                                                                                                        bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_besar_kecil = 'kecil' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                                        , concat('belakang', '-', 'kecil', '-', 'genap')
                                                                                                        , if (
                                                                                                            bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_besar_kecil = 'kecil' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                            , concat('belakang', '-', 'kecil', '-', 'ganjil')
                                                                                                            , if (
                                                                                                                bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_besar_kecil = 'besar' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                                                , concat('tengah', '-', 'besar', '-', 'genap')
                                                                                                                , if (
                                                                                                                    bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_besar_kecil = 'besar' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                                    , concat('tengah', '-', 'besar', '-', 'ganjil')
                                                                                                                    , if (
                                                                                                                        bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_besar_kecil = 'kecil' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                                                        , concat('tengah', '-', 'kecil', '-', 'genap')
                                                                                                                        , if (
                                                                                                                            bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_besar_kecil = 'kecil' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                                            , concat('tengah', '-', 'kecil', '-', 'ganjil')
                                                                                                                            , if (
                                                                                                                                bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_besar_kecil = 'besar' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                                                                , concat('depan', '-', 'besar', '-', 'genap')
                                                                                                                                , if (
                                                                                                                                    bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_besar_kecil = 'besar' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                                                    , concat('depan', '-', 'besar', '-', 'ganjil')
                                                                                                                                    , if (
                                                                                                                                        bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_besar_kecil = 'kecil' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                                                                        , concat('depan', '-', 'kecil', '-', 'genap')
                                                                                                                                        , if (
                                                                                                                                            bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_besar_kecil = 'kecil' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                                                            , concat('depan', '-', 'kecil', '-', 'ganjil')
                                                                                                                                            , 'nulled'
                                                                                                                                        )
                                                                                                                                    )
                                                                                                                                )
                                                                                                                            )
                                                                                                                        )
                                                                                                                    )
                                                                                                                )
                                                                                                            )
                                                                                                        )
                                                                                                    )
                                                                                                )
                                                                                            )
                                                                                            , if (
                                                                                                togel_game.id = 13
                                                                                                , if (
                                                                                                    bets_togel.tebak_genap_ganjil = 'genap'
                                                                                                    , 'genap'
                                                                                                    , if (
                                                                                                        bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                        , 'ganjil'
                                                                                                        , if (
                                                                                                            bets_togel.tebak_besar_kecil = 'besar'
                                                                                                            , 'besar'
                                                                                                            , if (
                                                                                                                bets_togel.tebak_besar_kecil = 'kecil'
                                                                                                                , 'kecil'
                                                                                                                , 'nulled'
                                                                                                            )
                                                                                                        )
                                                                                                    )
                                                                                                )
                                                                                                , if (
                                                                                                    togel_game.id = 14
                                                                                                    , togel_shio_name.name
                                                                                                    , 'nulled'
                                                                                                )
                                                                                            )
                                                                                        )
                                                                                    )
                                                                                )
                                                                            )
                                                                        )
                                                                    )
                                                                )
                                                            )
                                                        )
                                                    )
                                                )
                                            )
                                        )
                                    )
                                )
                            )
                        )
                    )
                ) as 'Nomor'
                , bets_togel.bet_amount as 'Bet'
                , bets_togel.pay_amount as 'Bayar'
                , bets_togel.win_nominal as 'winTogel'
                , CONCAT(REPLACE(FORMAT(bets_togel.tax_amount,1),',',-1), '%') as 'discKey'

                
                , if (
                    bets_togel.number_6 is not null and bets_togel.number_5 is not null and bets_togel.number_4 is not null and bets_togel.number_3 is not null and bets_togel.number_2 is null and bets_togel.number_1 is null
                    , concat(floor(togel_setting_game.win_4d_x), 'x')
                    , if (
                        bets_togel.number_6 is not null and bets_togel.number_5 is not null and bets_togel.number_4 is not null and bets_togel.number_3 is null and bets_togel.number_2 is null and bets_togel.number_1 is null
                        , concat(floor(togel_setting_game.win_3d_x), 'x')
                        , if (
                            bets_togel.number_6 is not null and bets_togel.number_5 is not null and bets_togel.number_4 is null and bets_togel.number_3 is null and bets_togel.number_2 is null and bets_togel.number_1 is null
                            , concat(floor(togel_setting_game.win_2d_x), 'x')
                            , if (
                                bets_togel.number_6 is null and bets_togel.number_5 is not null and bets_togel.number_4 is not null and bets_togel.number_3 is null and bets_togel.number_2 is null and bets_togel.number_1 is null
                                , concat(floor(togel_setting_game.win_2d_tengah_x), 'x')
                                , if (
                                    bets_togel.number_6 is null and bets_togel.number_5 is null and bets_togel.number_4 is not null and bets_togel.number_3 is not null and bets_togel.number_2 is null and bets_togel.number_1 is null
                                    , concat(floor(togel_setting_game.win_2d_depan_x), 'x')
                                    , if (
                                        togel_game.id = 5
                                        , concat(togel_setting_game.win_x, 'x')
                                        , if (
                                            togel_game.id = 6
                                            , concat(floor(togel_setting_game.win_2_digit), '/', floor(togel_setting_game.win_3_digit), '/', floor(togel_setting_game.win_4_digit), 'x')
                                            , if (
                                                togel_game.id = 7
                                                , concat(floor(togel_setting_game.win_3_digit), '/', floor(togel_setting_game.win_4_digit), 'x')
                                                , if (
                                                    togel_game.id = 8
                                                    , concat(if (
                                                        bets_togel.tebak_as_kop_kepala_ekor = 'as'
                                                        , concat(floor(togel_setting_game.win_as), 'x')
                                                        , if (
                                                            bets_togel.tebak_as_kop_kepala_ekor = 'kop'
                                                            , concat(floor(togel_setting_game.win_kop), 'x')
                                                            , if (
                                                                bets_togel.tebak_as_kop_kepala_ekor = 'kepala'
                                                                , concat(floor(togel_setting_game.win_kepala), 'x')
                                                                , if (
                                                                    bets_togel.tebak_as_kop_kepala_ekor = 'ekor'
                                                                    , concat(floor(togel_setting_game.win_ekor), 'x')
                                                                    , 'nulled'
                                                                )
                                                            )
                                                        )
                                                    ))
                                                    , if (
                                                        togel_game.id = 9
                                                        , if (
                                                            bets_togel.tebak_besar_kecil is null
                                                            , if (
                                                                bets_togel.tebak_genap_ganjil is null
                                                                , if (
                                                                    bets_togel.tebak_tengah_tepi is null
                                                                    , 'nulled'
                                                                    , concat(floor(togel_setting_game.win_x), 'x')
                                                                )
                                                                , concat(floor(togel_setting_game.win_x), 'x')
                                                            )
                                                            , concat(floor(togel_setting_game.win_x), 'x')
                                                        )
                                                        , if (
                                                            togel_game.id = 10
                                                            , if (
                                                                bets_togel.tebak_as_kop_kepala_ekor = 'as' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                , concat(floor(togel_setting_game.win_x), 'x')
                                                                , if (
                                                                    bets_togel.tebak_as_kop_kepala_ekor = 'as' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                    , concat(floor(togel_setting_game.win_x), 'x')
                                                                    , if (
                                                                        bets_togel.tebak_as_kop_kepala_ekor = 'kop' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                        , concat(floor(togel_setting_game.win_x), 'x')
                                                                        , if (
                                                                            bets_togel.tebak_as_kop_kepala_ekor = 'kop' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                            , concat(floor(togel_setting_game.win_x), 'x')
                                                                            , if (
                                                                                bets_togel.tebak_as_kop_kepala_ekor = 'kepala' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                , concat(floor(togel_setting_game.win_x), 'x')
                                                                                , if (
                                                                                    bets_togel.tebak_as_kop_kepala_ekor = 'kepala' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                    , concat(floor(togel_setting_game.win_x), 'x')
                                                                                    , if (
                                                                                        bets_togel.tebak_as_kop_kepala_ekor = 'ekor' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                        , concat(floor(togel_setting_game.win_x), 'x')
                                                                                        , if (
                                                                                            bets_togel.tebak_as_kop_kepala_ekor = 'ekor' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                            , concat(floor(togel_setting_game.win_x), 'x')
                                                                                            , if (
                                                                                                bets_togel.tebak_as_kop_kepala_ekor = 'as' and bets_togel.tebak_besar_kecil = 'besar'
                                                                                                , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                , if (
                                                                                                    bets_togel.tebak_as_kop_kepala_ekor = 'as' and bets_togel.tebak_besar_kecil = 'kecil'
                                                                                                    , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                    , if (
                                                                                                        bets_togel.tebak_as_kop_kepala_ekor = 'kop' and bets_togel.tebak_besar_kecil = 'besar'
                                                                                                        , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                        , if (
                                                                                                            bets_togel.tebak_as_kop_kepala_ekor = 'kop' and bets_togel.tebak_besar_kecil = 'kecil'
                                                                                                            , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                            , if (
                                                                                                                bets_togel.tebak_as_kop_kepala_ekor = 'kepala' and bets_togel.tebak_besar_kecil = 'besar'
                                                                                                                , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                                , if (
                                                                                                                    bets_togel.tebak_as_kop_kepala_ekor = 'kepala' and bets_togel.tebak_besar_kecil = 'kecil'
                                                                                                                    , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                                    , if (
                                                                                                                        bets_togel.tebak_as_kop_kepala_ekor = 'ekor' and bets_togel.tebak_besar_kecil = 'besar'
                                                                                                                        , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                                        , if (
                                                                                                                            bets_togel.tebak_as_kop_kepala_ekor = 'ekor' and bets_togel.tebak_besar_kecil = 'kecil'
                                                                                                                            , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                                            , 'nulled'
                                                                                                                        )
                                                                                                                    )
                                                                                                                )
                                                                                                            )
                                                                                                        )
                                                                                                    )
                                                                                                )
                                                                                            )
                                                                                        )
                                                                                    )
                                                                                )
                                                                            )
                                                                        )
                                                                    )
                                                                )
                                                            )
                                                            , if (
                                                                togel_game.id = 11
                                                                , if (
                                                                    bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_mono_stereo = 'stereo'
                                                                    , concat(floor(togel_setting_game.win_x), 'x')
                                                                    , if (
                                                                        bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_mono_stereo = 'mono'
                                                                        , concat(floor(togel_setting_game.win_x), 'x')
                                                                        , if (
                                                                            bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_kembang_kempis_kembar = 'kembang'
                                                                            , concat(floor(togel_setting_game.win_x), 'x')
                                                                            , if (
                                                                                bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_kembang_kempis_kembar = 'kempis'
                                                                                , concat(floor(togel_setting_game.win_x), 'x')
                                                                                , if (
                                                                                    bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_kembang_kempis_kembar = 'kembar'
                                                                                    , concat(floor(togel_setting_game.win_x), 'x')
                                                                                    , if (
                                                                                        bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_mono_stereo = 'stereo'
                                                                                        , concat(floor(togel_setting_game.win_x), 'x')
                                                                                        , if (
                                                                                            bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_mono_stereo = 'mono'
                                                                                            , concat(floor(togel_setting_game.win_x), 'x')
                                                                                            , if (
                                                                                                bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_kembang_kempis_kembar = 'kembang'
                                                                                                , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                , if (
                                                                                                    bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_kembang_kempis_kembar = 'kempis'
                                                                                                    , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                    , if (
                                                                                                        bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_kembang_kempis_kembar = 'kembar'
                                                                                                        , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                        , if (
                                                                                                            bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_mono_stereo = 'stereo'
                                                                                                            , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                            , if (
                                                                                                                bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_mono_stereo = 'mono'
                                                                                                                , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                                , if (
                                                                                                                    bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_kembang_kempis_kembar = 'kembang'
                                                                                                                    , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                                    , if (
                                                                                                                        bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_kembang_kempis_kembar = 'kempis'
                                                                                                                        , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                                        , if (
                                                                                                                            bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_kembang_kempis_kembar = 'kembar'
                                                                                                                            , concat(floor(togel_setting_game.win_x), 'x')
                                                                                                                            , 'nulled'
                                                                                                                        )
                                                                                                                    )
                                                                                                                )
                                                                                                            )
                                                                                                        )
                                                                                                    )
                                                                                                )
                                                                                            )
                                                                                        )
                                                                                    )
                                                                                )
                                                                            )
                                                                        )
                                                                    )
                                                                )
                                                                , if (
                                                                    togel_game.id = 12
                                                                    , if (
                                                                        bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_besar_kecil = 'besar' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                        , concat(togel_setting_game.win_x, 'x')
                                                                        , if (
                                                                            bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_besar_kecil = 'besar' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                            , concat(togel_setting_game.win_x, 'x')
                                                                            , if (
                                                                                bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_besar_kecil = 'kecil' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                , concat(togel_setting_game.win_x, 'x')
                                                                                , if (
                                                                                    bets_togel.tebak_depan_tengah_belakang = 'belakang' and bets_togel.tebak_besar_kecil = 'kecil' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                    , concat(togel_setting_game.win_x, 'x')
                                                                                    , if (
                                                                                        bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_besar_kecil = 'besar' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                        , concat(togel_setting_game.win_x, 'x')
                                                                                        , if (
                                                                                            bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_besar_kecil = 'besar' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                            , concat(togel_setting_game.win_x, 'x')
                                                                                            , if (
                                                                                                bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_besar_kecil = 'kecil' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                                , concat(togel_setting_game.win_x, 'x')
                                                                                                , if (
                                                                                                    bets_togel.tebak_depan_tengah_belakang = 'tengah' and bets_togel.tebak_besar_kecil = 'kecil' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                    , concat(togel_setting_game.win_x, 'x')
                                                                                                    , if (
                                                                                                        bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_besar_kecil = 'besar' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                                        , concat(togel_setting_game.win_x, 'x')
                                                                                                        , if (
                                                                                                            bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_besar_kecil = 'besar' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                            , concat(togel_setting_game.win_x, 'x')
                                                                                                            , if (
                                                                                                                bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_besar_kecil = 'kecil' and bets_togel.tebak_genap_ganjil = 'genap'
                                                                                                                , concat(togel_setting_game.win_x, 'x')
                                                                                                                , if (
                                                                                                                    bets_togel.tebak_depan_tengah_belakang = 'depan' and bets_togel.tebak_besar_kecil = 'kecil' and bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                                                    , concat(togel_setting_game.win_x, 'x')
                                                                                                                    , 'nulled'
                                                                                                                )
                                                                                                            )
                                                                                                        )
                                                                                                    )
                                                                                                )
                                                                                            )
                                                                                        )
                                                                                    )
                                                                                )
                                                                            )
                                                                        )
                                                                    )
                                                                    , if (
                                                                        togel_game.id = 13
                                                                        , if (
                                                                            bets_togel.tebak_genap_ganjil = 'genap'
                                                                            , concat(floor(togel_setting_game.win_x), 'x')
                                                                            , if (
                                                                                bets_togel.tebak_genap_ganjil = 'ganjil'
                                                                                , concat(floor(togel_setting_game.win_x), 'x')
                                                                                , if (
                                                                                    bets_togel.tebak_besar_kecil = 'besar'
                                                                                    , concat(floor(togel_setting_game.win_x), 'x')
                                                                                    , if (
                                                                                        bets_togel.tebak_besar_kecil = 'kecil'
                                                                                        , concat(floor(togel_setting_game.win_x), 'x')
                                                                                        , 'nulled'
                                                                                    )
                                                                                )
                                                                            )
                                                                        )
                                                                        , if (
                                                                            togel_game.id = 14
                                                                            , concat(floor(togel_setting_game.win_x), 'x')
                                                                            , 'nulled'
                                                                        )
                                                                    )
                                                                )
                                                            )
                                                        )
                                                    )
                                                )
                                            )
                                        )
                                    )
                                )
                            )
                        )
                    )
                ) as 'Win'
                , if (
                    bets_togel.updated_at is null
                    , 'Running'
                    , if (
                        bets_togel.win_lose_status = 1
                        , 'Win'
                        , 'Lose'
                    )
                ) as 'Status'
            ")
            ->where(DB::raw("DATE_FORMAT(bets_togel.created_at, '%Y-%m-%d %H:%i')"), Carbon::parse($date->created_at)->format('Y-m-d H:i'))
            // ->where('bets_togel.updated_at', null)
            ->where('bets_togel.created_by', $date->created_by)->get()->toArray();
    return $result;          
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

  //         return $this->successResponse(null, 'Tidak ada konten', 204);
  //     } catch (\Throwable $th) {
  //         return $this->errorResponse('Internal Server Error', 500);
  //     }
  // }

  public function winLoseStatus()
  {
    try {
      return $this->successResponse(null, 'Tidak ada konten', 204);
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
        ->withTrashed()
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
        ->withTrashed()
        ->where('members_id', $this->member->id)->latest()->first();

      $response = [
        'deposit' => null,
        'withdraw' => null,
      ];
      if ($deposit || $withdraw) {
        if ($deposit) {
          $depositStatus = $deposit->approval_status == 0 ? 'Pending' : ($deposit->approval_status == 1 ? 'Success' : 'Rejected');

          $response['deposit'] = [
            'amount' => $deposit->jumlah,
            'status' => $deposit->approval_status,
            'deposit_description' => $depositStatus,
            'created_at' => $deposit->created_at,
            'bank_member' => $deposit->bankNameMember,
          ];
        }

        if ($withdraw) {
          $wdStatus = $withdraw->approval_status == 0 ? 'Pending' : ($withdraw->approval_status == 1 ? 'Success' : 'Rejected');
          $response['withdraw'] = [
            'amount' => $withdraw->jumlah,
            'status' => $withdraw->approval_status,
            'withdraw_description' => $wdStatus,
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
        return $this->successResponse(null, 'Tidak ada konten', 204);
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
        return $this->successResponse('Tidak ada statement', 204);
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
        'credit as balance',
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
        'credit as balance',
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
    // validasi
    $validator = Validator::make($request->all(), [
      'constant_rekening_id' => 'required',
      'nomor_rekening' => 'required|min:8',
      'account_name' => 'required',
    ]);

    if ($validator->fails()) {
      return $this->errorResponse($validator->errors()->first(), 422);
    }

    try {
      // check account bank
      $rekMemberDupBank = RekMemberModel::leftJoin('constant_rekening', 'constant_rekening.id', 'rek_member.constant_rekening_id')
        ->leftJoin('rekening', 'rekening.id', 'rek_member.rekening_id')
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
        ->where('rek_member.constant_rekening_id', $request->constant_rekening_id)->first();
      
      // check no rekening
      $noRekArray = RekeningModel::pluck('nomor_rekening')->toArray();
      $noMemberArray = RekMemberModel::pluck('nomor_rekening')->toArray();
      $noRekArrays = array_merge($noRekArray, $noMemberArray);
      // dd($rekMemberDupBank);

      if ($rekMemberDupBank != null) {
        return $this->errorResponse('Melebihi Max per Bank, Hubungi customer service untuk penambahan', 400);
      } elseif ($request->constant_rekening_id && in_array($request->nomor_rekening, $noRekArrays)) {
        return $this->errorResponse('Nomor rekening yang anda masukkan telah digunakan', 400);
      } else {
        // MemoModel::insert($create);
        $rekeningDepoMember = RekeningModel::where('constant_rekening_id', '=', $request->constant_rekening_id)->where('is_wd', '=', 1)->first();
        // dd($rekeningDepoMember);
        $createRekMember = RekMemberModel::create([
          'username_member' => auth('api')->user()->username,
          'rekening_id' => $rekeningDepoMember->id,
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

        return $this->successResponse(null, 'Berhasil membuat rekening baru', 200);
      }
    } catch (\Exception $e) {
      return $this->errorResponse($e->getMessage(), 500);
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


      return $this->successResponse(null, 'Berhasil mengubah Rekening withdraw', 200);
    } catch (\Exception $e) {
      return $this->errorResponse('Hubungi CS kami untuk mengubah Rekening Withdraw', 500);
    }
  }
  
  // Daftar Rekeningmember
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

      return $this->successResponse($rekMember, 'Daftar Rekening ', 200);
    } catch (\Exception $e) {
      return $this->errorResponse('Internal Server Error', 500);
    }
  }
    // New Daftar Rekeningmember
    public function listRekAgent()
    {
        try {
            // $rekTujuan = RekeningTujuanDepo::where('created_by', auth('api')->user()->id)->first();
            // $bcaAgent = RekeningModel::join('constant_rekening', 'constant_rekening.id', 'rekening.constant_rekening_id')
            //     ->select([
            //         'rekening.id',
            //         'rekening.nama_rekening',
            //         'rekening.nomor_rekening',
            //         'constant_rekening.name',
            //     ])
            //     ->where('rekening.is_depo', '=', 1)
            //     ->where('rekening.id', $rekTujuan->rekening_id_tujuan_depo1)->first();
            // $mandiriAgent = RekeningModel::join('constant_rekening', 'constant_rekening.id', 'rekening.constant_rekening_id')
            //     ->select([
            //         'rekening.id',
            //         'rekening.nama_rekening',
            //         'rekening.nomor_rekening',
            //         'constant_rekening.name',
            //     ])
            //     ->where('rekening.is_depo', '=', 1)
            //     ->where('rekening.id', $rekTujuan->rekening_id_tujuan_depo2)->first();
            // $bniAgent = RekeningModel::join('constant_rekening', 'constant_rekening.id', 'rekening.constant_rekening_id')
            //     ->select([
            //         'rekening.id',
            //         'rekening.nama_rekening',
            //         'rekening.nomor_rekening',
            //         'constant_rekening.name',
            //     ])
            //     ->where('rekening.is_depo', '=', 1)
            //     ->where('rekening.id', $rekTujuan->rekening_id_tujuan_depo3)->first();
            // $briAgent = RekeningModel::join('constant_rekening', 'constant_rekening.id', 'rekening.constant_rekening_id')
            //     ->select([
            //         'rekening.id',
            //         'rekening.nama_rekening',
            //         'rekening.nomor_rekening',
            //         'constant_rekening.name',
            //     ])
            //     ->where('rekening.is_depo', '=', 1)
            //     ->where('rekening.id', $rekTujuan->rekening_id_tujuan_depo4)->first();
            // $cimbAgent = RekeningModel::join('constant_rekening', 'constant_rekening.id', 'rekening.constant_rekening_id')
            //     ->select([
            //         'rekening.id',
            //         'rekening.nama_rekening',
            //         'rekening.nomor_rekening',
            //         'constant_rekening.name',
            //     ])
            //     ->where('rekening.is_depo', '=', 1)
            //     ->where('rekening.id', $rekTujuan->rekening_id_tujuan_depo5)->first();
            // $danamondAgent = RekeningModel::join('constant_rekening', 'constant_rekening.id', 'rekening.constant_rekening_id')
            //     ->select([
            //         'rekening.id',
            //         'rekening.nama_rekening',
            //         'rekening.nomor_rekening',
            //         'constant_rekening.name',
            //     ])
            //     ->where('rekening.is_depo', '=', 1)
            //     ->where('rekening.id', $rekTujuan->rekening_id_tujuan_depo6)->first();
            // $telkomselAgent = RekeningModel::join('constant_rekening', 'constant_rekening.id', 'rekening.constant_rekening_id')
            //     ->select([
            //         'rekening.id',
            //         'rekening.nama_rekening',
            //         'rekening.nomor_rekening',
            //         'constant_rekening.name',
            //     ])
            //     ->where('is_default', 1)
            //     ->where('rekening.id', $rekTujuan->rekening_id_tujuan_depo7)->first();
            // $axiataAgent = RekeningModel::join('constant_rekening', 'constant_rekening.id', 'rekening.constant_rekening_id')
            //     ->select([
            //         'rekening.id',
            //         'rekening.nama_rekening',
            //         'rekening.nomor_rekening',
            //         'constant_rekening.name',
            //     ])
            //     ->where('is_default', 1)
            //     ->where('rekening.id', $rekTujuan->rekening_id_tujuan_depo8)->first();
            // $ovoAgent = RekeningModel::join('constant_rekening', 'constant_rekening.id', 'rekening.constant_rekening_id')
            //     ->select([
            //         'rekening.id',
            //         'rekening.nama_rekening',
            //         'rekening.nomor_rekening',
            //         'constant_rekening.name',
            //     ])
            //     ->where('is_default', 1)
            //     ->where('rekening.id', $rekTujuan->rekening_id_tujuan_depo9)->first();
            // $gopayAgent = RekeningModel::join('constant_rekening', 'constant_rekening.id', 'rekening.constant_rekening_id')
            //     ->select([
            //         'rekening.id',
            //         'rekening.nama_rekening',
            //         'rekening.nomor_rekening',
            //         'constant_rekening.name',
            //     ])
            //     ->where('is_default', 1)
            //     ->where('rekening.id', $rekTujuan->rekening_id_tujuan_depo10)->first();
            // $danaAgent = RekeningModel::join('constant_rekening', 'constant_rekening.id', 'rekening.constant_rekening_id')
            //     ->select([
            //         'rekening.id',
            //         'rekening.nama_rekening',
            //         'rekening.nomor_rekening',
            //         'constant_rekening.name',
            //     ])
            //     ->where('is_default', 1)
            //     ->where('rekening.id', $rekTujuan->rekening_id_tujuan_depo11)->first();
            // $linkAjaAgent = RekeningModel::join('constant_rekening', 'constant_rekening.id', 'rekening.constant_rekening_id')
            //     ->select([
            //         'rekening.id',
            //         'rekening.nama_rekening',
            //         'rekening.nomor_rekening',
            //         'constant_rekening.name',
            //     ])
            //     ->where('is_default', 1)
            //     ->where('rekening.id', $rekTujuan->rekening_id_tujuan_depo12)->first();
            // $bankName = ['bca', 'mandiri', 'bni', 'bri', 'cimb', 'danamond', 'telkomsel', 'axiata', 'ovo', 'gopay', 'dana', 'linkAja'];
            // $listRek = [];

            // for ($i=0; $i < count($bankName); $i++) { 
            //     array_push($listRek, ${$bankName[$i]."Agent"});
            // }
            $bankAgent = RekMemberModel::leftJoin('constant_rekening', 'constant_rekening.id', '=', 'rek_member.constant_rekening_id')
                        ->join('rekening', 'rekening.id', 'rek_member.rekening_id')
                        ->select([
                            'rekening.id',
                            'rekening.nama_rekening',
                            'rekening.nomor_rekening',
                            'constant_rekening.name',
                        ])
                        ->whereNull('rekening.deleted_by')
                        ->whereNull('rekening.deleted_at')
                        ->where('rek_member.created_by', auth('api')->user()->id)
                        ->get()->toArray();

            $nonBankAgent = RekeningModel::join('constant_rekening', 'constant_rekening.id', 'rekening.constant_rekening_id')
                            ->select([
                                'rekening.id',
                                'rekening.nama_rekening',
                                'rekening.nomor_rekening',
                                'constant_rekening.name',
                            ])
                            ->where('is_default', 1)
                            ->get()->toArray();

            $listRek = array_merge($bankAgent, $nonBankAgent);
            
            return $this->successResponse($listRek, 'Daftar Rekening Agent', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
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

      return $this->successResponse($rekMember, 'Daftar Rekening', 200);
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
              'content' => 'Selamat Anda Mendapatkan CASHBACK 5% = ' . $cashback5,
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
              'content' => 'Selamat Anda Mendapatkan CASHBACK 7% = ' . $cashback7,
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
              'content' => 'Selamat Anda Mendapatkan CASHBACK 10% = ' . $cashback10,
              'created_at' => Carbon::now(),
            ]);

            return $this->successResponse(null, 'CASHBACK 10%', 200);
          } else {
            return $this->successResponse(null, 'Tidak ada CASHBACK 123', 200);
          }
        } else {
          return $this->successResponse(null, 'Tidak ada bonus cashback slot yang di peroleh', 200);
        }
      }
    } catch (\Throwable $th) {
      return $this->errorResponse('Internal Server Error', 500);
    }
  }

  // Bonus Referal
  public function bonusReferal()
  {
    try {
      $bonus = ConstantProviderTogelModel::select('name', 'value')->where('status', true)->get();
      if ($bonus->count() < 1) {
        return $this->successResponse(null, 'Tidak ada data', 200);
      } else {
        return $this->successResponse($bonus, 'Bonus referal', 200);
      }
    } catch (\Throwable $th) {
      return $this->errorResponse($th->getMessage(), 500);
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
