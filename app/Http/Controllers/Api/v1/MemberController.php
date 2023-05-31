<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Models\BetModel;
use App\Models\BetsTogel;
use App\Models\BonusHistoryModel;
use App\Models\ConstantProvider;
use App\Models\ConstantProviderTogelModel;
use App\Models\DepositModel;
use App\Models\DepositWithdrawHistory;
use App\Models\ImageContent;
use App\Models\MembersModel;
use App\Models\MemoModel;
use App\Models\RekeningModel;
use App\Models\RekMemberModel;
use App\Models\TurnoverModel;
use App\Models\UserLogModel;
use App\Models\WithdrawModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator; # pagination pake ini
use Livewire\WithPagination;

# pagination pake ini

# pagination pake ini

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
    public $loginLout = [];
    public $togelReferal = [];

    // history by type
    public function historyAll(Request $request)
    {
        try {
            $id = auth('api')->user()->id;
            $fromDate = Carbon::now()->subMonth(2)->format('Y-m-d 00:00:00');
            $toDate = Carbon::now();
            $conditionDate = '2023-04-11 23:59:59'; # date condition to retrieve deposit and withdrawal history from table deposit_withdraw_history

            $query = BetModel::join('members', 'members.id', '=', 'bets.created_by')
                ->join('constant_provider', 'constant_provider.id', '=', 'bets.constant_provider_id')
                ->whereBetween('bets.created_at', [$fromDate, $toDate])
                ->whereIn('bets.type', ['Win', 'Lose', 'Bet', 'Settle', 'Refund']);

            # Histori Bonus
            $bonus = BonusHistoryModel::join('constant_bonus', 'constant_bonus.id', '=', 'bonus_history.constant_bonus_id')
                ->selectRaw("
                    bonus_history.id,
                    bonus_history.constant_bonus_id,
                    constant_bonus.nama_bonus,
                    bonus_history.type,
                    if(
                        bonus_history.jumlah < 0
                        , (bonus_history.jumlah * -1)
                        , bonus_history.jumlah
                    ) as jumlah,
                    bonus_history.credit,
                    bonus_history.hadiah,
                    if(
                        bonus_history.constant_bonus_id = 4
                        , if (bonus_history.updated_at is null, bonus_history.created_at, bonus_history.updated_at)
                        , bonus_history.created_at
                    ) as created_at,
                    bonus_history.member_id
                ")
                ->whereBetween('bonus_history.created_at', [$fromDate, $toDate])
                ->whereNotIn('bonus_history.constant_bonus_id', [3])
                ->where('bonus_history.is_send', 1)
                ->where('bonus_history.member_id', auth('api')->user()->id)
                ->orderBy('bonus_history.created_at', 'desc');

            $referalMembers = MembersModel::select('id')->where('id', $id)
                ->with([
                    'referrals' => function ($query) use ($fromDate, $toDate) {
                        $query->with([
                            'betTogels' => function ($query) use ($fromDate, $toDate) {
                                $query->selectRaw("created_by, id as bet_id, bonus_daily_referal, balance_upline_referral, created_at")->where('bonus_daily_referal', '>', 0)->whereBetween('created_at', [$fromDate, $toDate])->orderBy('created_at', 'desc');
                            },
                            'bets' => function ($query) use ($fromDate, $toDate) {
                                $query->selectRaw("constant_provider_id, created_by, game_id as bet_id, bonus_daily_referal, credit_upline_referral, created_at")->where('bonus_daily_referal', '>', 0)->whereBetween('created_at', [$fromDate, $toDate])->orderBy('created_at', 'desc');
                            },
                        ])->select(['referrer_id', 'id', 'username']);
                    }])->first()->toArray();

            if ($request->type == 'depositWithdraw') { # History Desposit & Withdraw
                if ($fromDate <= $conditionDate) {
                    # History Deposit
                    $deposit = DB::select("SELECT
                        'Deposit' as tables,
                        jumlah,
                        credit,
                        approval_status,
                        created_at,
                        created_by,
                        if (
                            approval_status = 0,
                            'Pending',
                            if (
                                approval_status = 1,
                                'Success',
                                if (
                                    approval_status = 2,
                                    'Rejected',
                                    'nulled'
                                )
                            )
                        ) as 'deposit status'
                    FROM
                        deposit
                    WHERE
                        members_id = $id
                        AND created_at BETWEEN '$fromDate' AND '$conditionDate'
                    ORDER BY
                        created_at DESC");

                    # History Withdraw
                    $withdraw = DB::select("SELECT
                        'Withdraw' as tables,
                        jumlah,
                        credit,
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
                        members_id = $id
                        AND created_at BETWEEN '$fromDate' AND '$conditionDate'
                    ORDER BY
                        created_at
                    DESC");

                    $depoWithdrawHistory = DB::select("SELECT
                            IF(
                                deposit_id is null
                                , 'Withdraw'
                                , 'Deposit'
                            ) AS tables,
                            amount as jumlah,
                            credit,
                            IF (
                                status = 'Pending'
                                , 0
                                , IF (
                                    status = 'Approved'
                                    , 1
                                    , IF (
                                        status = 'Rejected'
                                        , 2
                                        , 3
                                    )
                                )
                            ) AS approval_status,
                            created_at,
                            created_by,
                            IF(
                                deposit_id is not null
                                , IF (
                                    status = 'Approved'
                                    , 'Success'
                                    , status
                                )
                                , NULL
                            ) AS 'deposit status',
                            IF(
                                withdraw_id is not null
                                , IF (
                                    status = 'Approved'
                                    , 'Success'
                                    , status
                                )
                                , NULL
                            ) AS 'withdraw status'
                        FROM
                            deposit_withdraw_history
                        WHERE
                            member_id = $id
                            AND created_at BETWEEN '$conditionDate' AND '$toDate'
                        ORDER BY
                            created_at
                        DESC");

                    $depoWD = array_merge($deposit, $withdraw, $depoWithdrawHistory);
                    $date = array_column($depoWD, 'created_at');
                    array_multisort($date, SORT_DESC, $depoWD);
                    $data = $this->paginate($depoWD, $this->perPageWd);

                    return [
                        'status' => 'success',
                        'depositWithdraw' => $data,
                    ];

                } else {
                    $depoWithdrawHistory = DepositWithdrawHistory::selectRaw("
                            IF(
                                deposit_id is null
                                , 'Withdraw'
                                , 'Deposit'
                            ) AS tables,
                            amount as jumlah,
                            credit,
                            IF (
                                status = 'Pending'
                                , 0
                                , IF (
                                    status = 'Approved'
                                    , 1
                                    , IF (
                                        status = 'Rejected'
                                        , 2
                                        , 3
                                    )
                                )
                            ) AS approval_status,
                            created_at,
                            created_by,
                            IF(
                                deposit_id is not null
                                , IF (
                                    status = 'Approved'
                                    , 'Success'
                                    , status
                                )
                                , NULL
                            ) AS 'deposit status',
                            IF(
                                withdraw_id is not null
                                , IF (
                                    status = 'Approved'
                                    , 'Success'
                                    , status
                                )
                                , NULL
                            ) AS 'withdraw status'
                        ")
                        ->where('member_id', $id)
                        ->whereBetween('created_at', [$fromDate, $toDate])
                        ->orderBy('created_at', 'DESC')
                        ->get()->toArray() ?? [];

                    $data = $this->paginate($depoWithdrawHistory, $this->perPageWd);

                    return [
                        'status' => 'success',
                        'depositWithdraw' => $data,
                    ];
                }

            } elseif ($request->type == 'loginLogout') { # History Login/Logout
                # Login / Logout Filter
                $activity_members = DB::select("SELECT
                                        properties,
                                        created_at
                                    FROM
                                        activity_log
                                    WHERE
                                        log_name = 'Member Login' OR log_name ='Member Log Out'
                                        AND created_at BETWEEN '$fromDate' AND '$toDate'
                                    ORDER BY
                                        created_at
                                    DESC");

                $properties = [];
                foreach ($activity_members as $activity) {
                    $array = json_decode($activity->properties, true);
                    if (!array_key_exists('device', $array) && !array_key_exists('created_at', $array)) {
                        $device = Arr::add($array, 'device', 'Unknown');
                        $properties[] = Arr::add($device, 'created_at', $activity->created_at);
                    } else {
                        $properties[] = Arr::add($array, 'created_at', $activity->created_at);
                    }
                }

                $member = MembersModel::where('id', $id)->first();
                $activity = [];
                $filterDate = collect($properties)->whereBetween('created_at', [$fromDate, $toDate])->all();
                foreach ($filterDate as $index => $json) {
                    if ($json['target'] == $member->username) {
                        $data = [
                            "ip" => $json['ip'],
                            "target" => $json['target'],
                            "activity" => $json['device'] == null ? $json['activity'] : $json['activity'] . ' - ' . $json['device'],
                            "created_at" => $json['created_at'],
                        ];
                        $activity[] = $data;
                    }
                }
                $this->loginLout = $activity;
                $loginLout = $this->paginate($this->loginLout, $this->perPage);
                return [
                    'status' => 'success',
                    'loginLogout' => $loginLout,
                ];
            } elseif ($request->type == 'referralTogel') { # History Referral Togel
                $togelReferal = [];
                foreach ($referalMembers['referrals'] as $key => $item) {
                    if ($item['bet_togels'] != []) {
                        foreach ($item['bet_togels'] as $value) {
                            $togelReferal[] = [
                                'created_at' => $value['created_at'],
                                'deskripsi' => 'Dari downline referal Anda ' . $item['username'] . ' bermain Togel',
                                'bonus' => $value['bonus_daily_referal'],
                                'balance' => $value['balance_upline_referral'],
                            ];
                        }
                    }
                }
                $togelReferal = $this->paginate($togelReferal, $this->perPage);
                return [
                    'status' => 'success',
                    'referralTogel' => $togelReferal,
                ];
            } elseif ($request->type == 'referralPragmaticSlot') { # History Referral Pragmatic Slot
                $PragmaticSlotReferal = [];
                foreach ($referalMembers['referrals'] as $key => $item) {
                    if ($item['bets'] != []) {
                        $PragmaticSlot = collect($item['bets'])->where('constant_provider_id', 1)->all();
                        foreach ($PragmaticSlot as $value) {
                            $PragmaticSlotReferal[] = [
                                'created_at' => $value['created_at'],
                                'deskripsi' => 'Dari downline referal Anda ' . $item['username'] . ' bermain Pragmatic Slot',
                                'bonus' => $value['bonus_daily_referal'],
                                'balance' => $value['credit_upline_referral'],
                            ];
                        }

                    }
                }

                $data = $this->paginate($PragmaticSlotReferal, $this->perPage);
                return [
                    'status' => 'success',
                    'referralPragmaticSlot' => $data,
                ];
            } elseif ($request->type == 'referralPragmaticLiveCasino') { # History Referral Pragmatic Live Casino
                $PragmaticLiveCasinoReferal = [];
                foreach ($referalMembers['referrals'] as $key => $item) {
                    if ($item['bets'] != []) {
                        $PragmaticLiveCasino = collect($item['bets'])->where('constant_provider_id', 10)->all();
                        foreach ($PragmaticLiveCasino as $value) {
                            $PragmaticLiveCasinoReferal[] = [
                                'created_at' => $value['created_at'],
                                'deskripsi' => 'Dari downline referal Anda ' . $item['username'] . ' bermain Pragmatic Live Casino',
                                'bonus' => $value['bonus_daily_referal'],
                                'balance' => $value['credit_upline_referral'],
                            ];
                        }

                    }
                }

                $data = $this->paginate($PragmaticLiveCasinoReferal, $this->perPage);
                return [
                    'status' => 'success',
                    'referralPragmaticLiveCasino' => $data,
                ];
            } elseif ($request->type == 'referralHabaneroSlot') { # History Referral Habanero Slot
                $HabaneroSlotReferal = [];
                foreach ($referalMembers['referrals'] as $key => $item) {
                    if ($item['bets'] != []) {
                        $HabaneroSlot = collect($item['bets'])->where('constant_provider_id', 2)->all();
                        foreach ($HabaneroSlot as $value) {
                            $HabaneroSlotReferal[] = [
                                'created_at' => $value['created_at'],
                                'deskripsi' => 'Dari downline referal Anda ' . $item['username'] . ' bermain Habanero Slot',
                                'bonus' => $value['bonus_daily_referal'],
                                'balance' => $value['credit_upline_referral'],
                            ];
                        }

                    }
                }

                $data = $this->paginate($HabaneroSlotReferal, $this->perPage);
                return [
                    'status' => 'success',
                    'referralHabaneroSlot' => $data,
                ];
            } elseif ($request->type == 'referralJokerSlot') { # History Referral Joker Gaming Slot
                $JokerSlotReferal = [];
                foreach ($referalMembers['referrals'] as $key => $item) {
                    if ($item['bets'] != []) {
                        $JokerSlot = collect($item['bets'])->where('constant_provider_id', 3)->all();
                        foreach ($JokerSlot as $value) {
                            $JokerSlotReferal[] = [
                                'created_at' => $value['created_at'],
                                'deskripsi' => 'Dari downline referal Anda ' . $item['username'] . ' bermain Joker Slot',
                                'bonus' => $value['bonus_daily_referal'],
                                'balance' => $value['credit_upline_referral'],
                            ];
                        }

                    }
                }

                $data = $this->paginate($JokerSlotReferal, $this->perPage);
                return [
                    'status' => 'success',
                    'referralJokerSlot' => $data,
                ];
            } elseif ($request->type == 'referralJokerFish') { # History Referral Joker Gaming Fish
                $JokerFishReferal = [];
                foreach ($referalMembers['referrals'] as $key => $item) {
                    if ($item['bets'] != []) {
                        $JokerFish = collect($item['bets'])->where('constant_provider_id', 13)->all();
                        foreach ($JokerFish as $value) {
                            $JokerFishReferal[] = [
                                'created_at' => $value['created_at'],
                                'deskripsi' => 'Dari downline referal Anda ' . $item['username'] . ' bermain Joker Fish',
                                'bonus' => $value['bonus_daily_referal'],
                                'balance' => $value['credit_upline_referral'],
                            ];
                        }

                    }
                }

                $data = $this->paginate($JokerFishReferal, $this->perPage);
                return [
                    'status' => 'success',
                    'referralJokerFish' => $data,
                ];
            } elseif ($request->type == 'referralSpadeSlot') { # History Referral Spade Gaming Slot
                $SpadeSlotReferal = [];
                foreach ($referalMembers['referrals'] as $key => $item) {
                    if ($item['bets'] != []) {
                        $SpadeSlot = collect($item['bets'])->where('constant_provider_id', 4)->all();
                        foreach ($SpadeSlot as $value) {
                            $SpadeSlotReferal[] = [
                                'created_at' => $value['created_at'],
                                'deskripsi' => 'Dari downline referal Anda ' . $item['username'] . ' bermain Spade Slot',
                                'bonus' => $value['bonus_daily_referal'],
                                'balance' => $value['credit_upline_referral'],
                            ];
                        }

                    }
                }

                $data = $this->paginate($SpadeSlotReferal, $this->perPage);
                return [
                    'status' => 'success',
                    'referralSpadeSlot' => $data,
                ];
            } elseif ($request->type == 'referralSpadeFish') { # History Referral Spade Gaming Fish
                $SpadeFishReferal = [];
                foreach ($referalMembers['referrals'] as $key => $item) {
                    if ($item['bets'] != []) {
                        $SpadeFish = collect($item['bets'])->where('constant_provider_id', 14)->all();
                        foreach ($SpadeFish as $value) {
                            $SpadeFishReferal[] = [
                                'created_at' => $value['created_at'],
                                'deskripsi' => 'Dari downline referal Anda ' . $item['username'] . ' bermain Spade Fish',
                                'bonus' => $value['bonus_daily_referal'],
                                'balance' => $value['credit_upline_referral'],
                            ];
                        }

                    }
                }

                $data = $this->paginate($SpadeFishReferal, $this->perPage);
                return [
                    'status' => 'success',
                    'referralSpadeFish' => $data,
                ];
            } elseif ($request->type == 'referralPGSoftSlot') { # History Referral PG Soft Slot
                $PGSoftSlotReferal = [];
                foreach ($referalMembers['referrals'] as $key => $item) {
                    if ($item['bets'] != []) {
                        $PGSoftSlot = collect($item['bets'])->where('constant_provider_id', 5)->all();
                        foreach ($PGSoftSlot as $value) {
                            $PGSoftSlotReferal[] = [
                                'created_at' => $value['created_at'],
                                'deskripsi' => 'Dari downline referal Anda ' . $item['username'] . ' bermain PGSoft Slot',
                                'bonus' => $value['bonus_daily_referal'],
                                'balance' => $value['credit_upline_referral'],
                            ];
                        }

                    }
                }

                $data = $this->paginate($PGSoftSlotReferal, $this->perPage);
                return [
                    'status' => 'success',
                    'referralPGSoftSlot' => $data,
                ];
            } elseif ($request->type == 'referralJDBSlot') { # History Referral JDB Slot
                $JDBSlotReferal = [];
                foreach ($referalMembers['referrals'] as $key => $item) {
                    if ($item['bets'] != []) {
                        $JDBSlot = collect($item['bets'])->where('constant_provider_id', 7)->all();
                        foreach ($JDBSlot as $value) {
                            $JDBSlotReferal[] = [
                                'created_at' => $value['created_at'],
                                'deskripsi' => 'Dari downline referal Anda ' . $item['username'] . ' bermain JDB Slot',
                                'bonus' => $value['bonus_daily_referal'],
                                'balance' => $value['credit_upline_referral'],
                            ];
                        }

                    }
                }

                $data = $this->paginate($JDBSlotReferal, $this->perPage);
                return [
                    'status' => 'success',
                    'referralJDBSlot' => $data,
                ];
            } elseif ($request->type == 'referralJDBFish') { # History Referral JDB Fish
                $JDBFishReferal = [];
                foreach ($referalMembers['referrals'] as $key => $item) {
                    if ($item['bets'] != []) {
                        $JDBFish = collect($item['bets'])->where('constant_provider_id', 15)->all();
                        foreach ($JDBFish as $value) {
                            $JDBFishReferal[] = [
                                'created_at' => $value['created_at'],
                                'deskripsi' => 'Dari downline referal Anda ' . $item['username'] . ' bermain JDB Fish',
                                'bonus' => $value['bonus_daily_referal'],
                                'balance' => $value['credit_upline_referral'],
                            ];
                        }

                    }
                }

                $data = $this->paginate($JDBFishReferal, $this->perPage);
                return [
                    'status' => 'success',
                    'referralJDBFish' => $data,
                ];
            } elseif ($request->type == 'referralSexyGamingLiveCasino') { # History Referral Sexy Gaming Live Casino
                $SexyGamingLiveCasinoReferal = [];
                foreach ($referalMembers['referrals'] as $key => $item) {
                    if ($item['bets'] != []) {
                        $SexyGamingLiveCasino = collect($item['bets'])->where('constant_provider_id', 11)->all();
                        foreach ($SexyGamingLiveCasino as $value) {
                            $SexyGamingLiveCasinoReferal[] = [
                                'created_at' => $value['created_at'],
                                'deskripsi' => 'Dari downline referal Anda ' . $item['username'] . ' bermain Sexy Gaming Live Casino',
                                'bonus' => $value['bonus_daily_referal'],
                                'balance' => $value['credit_upline_referral'],
                            ];
                        }

                    }
                }

                $data = $this->paginate($SexyGamingLiveCasinoReferal, $this->perPage);
                return [
                    'status' => 'success',
                    'referralSexyGamingLiveCasino' => $data,
                ];
            } elseif ($request->type == 'referralSV388Live') { # History Referral SV388 Live
                $SV388LiveReferal = [];
                foreach ($referalMembers['referrals'] as $key => $item) {
                    if ($item['bets'] != []) {
                        $SV388Live = collect($item['bets'])->where('constant_provider_id', 18)->all();
                        foreach ($SV388Live as $value) {
                            $SV388LiveReferal[] = [
                                'created_at' => $value['created_at'],
                                'deskripsi' => 'Dari downline referal Anda ' . $item['username'] . ' bermain SV88 Live',
                                'bonus' => $value['bonus_daily_referal'],
                                'balance' => $value['credit_upline_referral'],
                            ];
                        }

                    }
                }

                $data = $this->paginate($SV388LiveReferal, $this->perPage);
                return [
                    'status' => 'success',
                    'referralSV388Live' => $data,
                ];
            } elseif ($request->type == 'referralSAGaming') { # History Referral SA Gaming Live Casino
                $SAGamingReferal = [];
                foreach ($referalMembers['referrals'] as $key => $item) {
                    if ($item['bets'] != []) {
                        $SAGaming = collect($item['bets'])->where('constant_provider_id', 19)->all();
                        foreach ($SAGaming as $value) {
                            $SAGamingReferal[] = [
                                'created_at' => $value['created_at'],
                                'deskripsi' => 'Dari downline referal Anda ' . $item['username'] . ' bermain SA Gaming Live Casino',
                                'bonus' => $value['bonus_daily_referal'],
                                'balance' => $value['credit_upline_referral'],
                            ];
                        }

                    }
                }

                $data = $this->paginate($SAGamingReferal, $this->perPage);
                return [
                    'status' => 'success',
                    'referralSAGaming' => $data,
                ];
            } elseif ($request->type == 'referralBGGaming') { # History Referral BG Gaming Live Casino
                $BGGamingReferal = [];
                foreach ($referalMembers['referrals'] as $key => $item) {
                    if ($item['bets'] != []) {
                        $BGGaming = collect($item['bets'])->where('constant_provider_id', 17)->all();
                        foreach ($BGGaming as $value) {
                            $BGGamingReferal[] = [
                                'created_at' => $value['created_at'],
                                'deskripsi' => 'Dari downline referal Anda ' . $item['username'] . ' bermain BG Gaming Live Casino',
                                'bonus' => $value['bonus_daily_referal'],
                                'balance' => $value['credit_upline_referral'],
                            ];
                        }

                    }
                }

                $data = $this->paginate($BGGamingReferal, $this->perPage);
                return [
                    'status' => 'success',
                    'referralBGGaming' => $data,
                ];
            } elseif ($request->type == 'referralIONXLiveCasino') { # History Referral IONX Live Casino
                $IONXLiveCasinoReferal = [];
                foreach ($referalMembers['referrals'] as $key => $item) {
                    if ($item['bets'] != []) {
                        $IONXLiveCasino = collect($item['bets'])->where('constant_provider_id', 8)->all();
                        foreach ($IONXLiveCasino as $value) {
                            $IONXLiveCasinoReferal[] = [
                                'created_at' => $value['created_at'],
                                'deskripsi' => 'Dari downline referal Anda ' . $item['username'] . ' bermain IONX Live Casino',
                                'bonus' => $value['bonus_daily_referal'],
                                'balance' => $value['credit_upline_referral'],
                            ];
                        }

                    }
                }

                $data = $this->paginate($IONXLiveCasinoReferal, $this->perPage);
                return [
                    'status' => 'success',
                    'referralIONXLiveCasino' => $data,
                ];
            } elseif ($request->type == 'referralSlot88') { # History Referral Slot88
                $Slot88Referal = [];
                foreach ($referalMembers['referrals'] as $key => $item) {
                    if ($item['bets'] != []) {
                        $Slot88 = collect($item['bets'])->where('constant_provider_id', 8)->all();
                        foreach ($Slot88 as $value) {
                            $Slot88Referal[] = [
                                'created_at' => $value['created_at'],
                                'deskripsi' => 'Dari downline referal Anda ' . $item['username'] . ' bermain Slot88',
                                'bonus' => $value['bonus_daily_referal'],
                                'balance' => $value['credit_upline_referral'],
                            ];
                        }

                    }
                }

                $data = $this->paginate($Slot88Referal, $this->perPage);
                return [
                    'status' => 'success',
                    'referralSlot88' => $data,
                ];
            } elseif ($request->type == 'referralOneGameSlot') { # History Referral One Game Slot
                $OneGameSlotReferal = [];
                foreach ($referalMembers['referrals'] as $key => $item) {
                    if ($item['bets'] != []) {
                        $OneGameSlot = collect($item['bets'])->where('constant_provider_id', 9)->all();
                        foreach ($OneGameSlot as $value) {
                            $OneGameSlotReferal[] = [
                                'created_at' => $value['created_at'],
                                'deskripsi' => 'Dari downline referal Anda ' . $item['username'] . ' bermain One Game Slot',
                                'bonus' => $value['bonus_daily_referal'],
                                'balance' => $value['credit_upline_referral'],
                            ];
                        }
                    }
                }

                $data = $this->paginate($OneGameSlotReferal, $this->perPage);
                return [
                    'status' => 'success',
                    'referralOneGameSlot' => $data,
                ];
            } elseif ($request->type == 'referralRedTigerSlot') { # History Referral Red Tiger Slot
                $RedTigerSlotReferal = [];
                foreach ($referalMembers['referrals'] as $key => $item) {
                    if ($item['bets'] != []) {
                        $RedTigerSlot = collect($item['bets'])->where('constant_provider_id', 12)->all();
                        foreach ($RedTigerSlot as $value) {
                            $RedTigerSlotReferal[] = [
                                'created_at' => $value['created_at'],
                                'deskripsi' => 'Dari downline referal Anda ' . $item['username'] . ' bermain Red Tiger Slot',
                                'bonus' => $value['bonus_daily_referal'],
                                'balance' => $value['credit_upline_referral'],
                            ];
                        }
                    }
                }

                $data = $this->paginate($RedTigerSlotReferal, $this->perPage);
                return [
                    'status' => 'success',
                    'referralRedTigerSlot' => $data,
                ];
            } elseif ($request->type == 'transaksiPragmaticSlot') { # History Transaksi Pragmatic Slot
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
                    'transaksiPragmaticSlot' => $data,
                ];
            } elseif ($request->type == 'transaksipragmaticLiveCasino') { # History Transaksi Pragmatic Live Casino
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
                    'transaksipragmaticLiveCasino' => $data,
                ];
            } elseif ($request->type == 'transaksiHabaneroSlot') { # History Transaksi Habanero Slot
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
                    'transaksiHabaneroSlot' => $data,
                ];
            } elseif ($request->type == 'transaksiJokerSlot') { # History Transaksi Joker Gaming Slot
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
                    'transaksiJokerSlot' => $data,
                ];
            } elseif ($request->type == 'transaksiJokerFish') { # History Transaksi Joker Gaming Fish
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
                    'transaksiJokerFish' => $data,
                ];
            } elseif ($request->type == 'transaksiSpadeSlot') { # History Transaksi Spade Gaming Slot
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
                    'transaksiSpadeSlot' => $data,
                ];
            } elseif ($request->type == 'transaksiSpadeFish') { # History Transaksi Spade Gaming Fish
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
                    'transaksiSpadeFish' => $data,
                ];
            } elseif ($request->type == 'transaksiPGSoftSlot') { # History Transaksi PG Soft Slot
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
                    'transaksiPGSoftSlot' => $data,
                ];
                // } elseif ($request->type == 'transaksiPlaytechSlot') { # History Transaksi Playtech Slot
                //     $playtechSlot = $query->select(
                //         'bets.bet',
                //         'bets.game_info',
                //         'bets.bet_id',
                //         'bets.game_id',
                //         'bets.deskripsi',
                //         'bets.credit',
                //         'bets.win',
                //         'bets.type',
                //         'bets.created_at',
                //         'constant_provider.constant_provider_name'
                //     )
                //         ->where('bets.created_by', auth('api')->user()->id)
                //         ->where('bets.constant_provider_id', 6)
                //         ->orderBy('bets.created_at', 'desc')->get();

                //     $data = $this->paginate($playtechSlot->toArray(), $this->perPage);

                //     return [
                //         'status' => 'success',
                //         'transaksiPlaytechSlot' => $data,
                //     ];
            } elseif ($request->type == 'transaksiJDBSlot') { # History Transaksi JDB Slot
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
                    'transaksiJDBSlot' => $data,
                ];
            } elseif ($request->type == 'transaksiJDBFish') { # History Transaksi JDB Fish
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
                    'transaksiJDBFish' => $data,
                ];
            } elseif ($request->type == 'transaksiSexyGamingLiveCasino') { # History Transaksi Sexy Gaming Live Casino
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
                    'transaksiSexyGamingLiveCasino' => $data,
                ];
            } elseif ($request->type == 'transaksiSV388Live') { # History Transaksi SV388 Live
                $sv388Live = $query->select(
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
                    ->where('bets.constant_provider_id', 18)
                    ->orderBy('bets.created_at', 'desc')->get();

                // $this->gamehallBet = $ghBet->toArray();
                $data = $this->paginate($sv388Live->toArray(), $this->perPage);

                return [
                    'status' => 'success',
                    'transaksiSV388Live' => $data,
                ];
            } elseif ($request->type == 'transaksiSAGaming') { # History Transaksi SA Gaming Live Casino
                $SAGaming = $query->select(
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
                    ->where('bets.constant_provider_id', 19)
                    ->orderBy('bets.created_at', 'desc')->get();

                // $this->gamehallBet = $ghBet->toArray();
                $data = $this->paginate($SAGaming->toArray(), $this->perPage);

                return [
                    'status' => 'success',
                    'transaksiSAGaming' => $data,
                ];
            } elseif ($request->type == 'transaksiBGGaming') { # History Transaksi BG Gaming Live Casino
                $BGGaming = $query->select(
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
                    ->where('bets.constant_provider_id', 17)
                    ->orderBy('bets.created_at', 'desc')->get();

                // $this->gamehallBet = $ghBet->toArray();
                $data = $this->paginate($BGGaming->toArray(), $this->perPage);

                return [
                    'status' => 'success',
                    'transaksiBGGaming' => $data,
                ];
            } elseif ($request->type == 'transaksiIONXLiveCasino') { # History Transaksi IONX Live Casino
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
                    'transaksiIONXLiveCasino' => $data,
                ];
            } elseif ($request->type == 'transaksiSlot88') { # History Transaksi Slot88
                $slot88 = $query->select(
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
                    ->where('bets.constant_provider_id', 20)
                    ->orderBy('bets.created_at', 'desc')->get();

                // $this->ionxBet = $iBet->toArray();
                $data = $this->paginate($slot88->toArray(), $this->perPage);

                return [
                    'status' => 'success',
                    'transaksiSlot88' => $data,
                ];
            } elseif ($request->type == 'transaksiOneGameSlot') { # History Transaksi One Game Slot
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
                    'transaksiOneGameSlot' => $data,
                ];
            } elseif ($request->type == 'transaksiRedTigerSlot') { # History Transaksi Red Tiger Slot
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
                    'transaksiRedTigerSlot' => $data,
                ];
            } elseif ($request->type == 'transaksiBonusPromo') { # History Transaksi Bonus Promo
                $bonusHistory = [];
                foreach ($bonus->get() as $key => $value) {
                    $status_bonus = preg_match("/menyerah/i", $value->hadiah) ? 'Menyerah' : (preg_match("/mendapatkan/i", $value->hadiah) ? 'Klaim' : (preg_match("/gagal/i", $value->hadiah) ? 'Gagal' : (preg_match("/batalkan/i", $value->hadiah) ? 'Cancel' : 'Klaim')));
                    $bonusHistory[] = [
                        'id' => $value->id,
                        'nama_bonus' => $value->nama_bonus,
                        'type' => $value->type,
                        'jumlah' => $value->jumlah,
                        'credit' => $value->credit ?? 0,
                        'hadiah' => $value->hadiah,
                        'status_bonus' => $status_bonus,
                        'created_at' => $value->created_at,
                        'member_id' => $value->member_id,
                    ];
                }
                $date = array_column($bonusHistory, 'created_at');
                array_multisort($date, SORT_DESC, $bonusHistory);
                $bonusArr = $this->paginate($bonusHistory, $this->perPage);

                return [
                    'status' => 'success',
                    'transaksiBonusPromo' => $bonusArr,
                ];
            } elseif ($request->type == 'transaksitogel') { # History Transaksi Togel Game
                $togel = $this->paginate($this->getTogel(), $this->perPage);

                return [
                    'status' => 'success',
                    'transaksitogel' => $togel,
                ];
            } else { # History All
                # History bets
                $providers = $query->where('bets.created_by', auth('api')->user()->id)
                    ->selectRaw("
                      'Bets' AS Tables,
                      bets.bet as betsBet,
                      bets.win as betsWin,
                      bets.game_info as betsGameInfo,
                      bets.bet_id as betsBetId,
                      bets.game_id as betsGameId,
                      bets.deskripsi as betsDeskripsi,
                      bets.credit as betsCredit,
                      bets.created_at as created_at,
                      constant_provider.constant_provider_name as betsProviderName,
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
                      NULL as bonusHistoryStatus,
                      NULL as bonusHistoryCredit,
                      NULL as activityDeskripsi,
                      NULL as activityName,
                      NULL as detail
                    ")->get()->toArray();

                # History deposit, withdraw
                if ($fromDate <= $conditionDate) {
                    $depositWithdraw = DB::select(
                        DB::raw("SELECT
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
                            NULL as bonusHistoryStatus,
                            NULL as bonusHistoryCredit,
                            NULL as activityDeskripsi,
                            NULL as activityName,
                            NULL as detail
                            FROM
                                deposit as a
                            WHERE
                                a.members_id = $id
                                AND a.created_at BETWEEN '$fromDate' AND '$conditionDate'
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
                            NULL as bonusHistoryStatus,
                            NULL as bonusHistoryCredit,
                            NULL as activityDeskripsi,
                            NULL as activityName,
                            NULL as detail
                        FROM
                            withdraw as a
                        WHERE
                            a.members_id = $id
                            AND a.created_at BETWEEN '$fromDate' AND '$conditionDate'
                        ORDER BY created_at DESC")
                    );

                    $depoWithdrawHistory = DB::select("SELECT
                            IF(
                                deposit_id is null
                                , 'Withdraw'
                                , 'Deposit'
                            ) AS Tables,
                            NULL as betsBet,
                            NULL as betsWin,
                            NULL as betsGameInfo,
                            NULL as betsBetId,
                            NULL as betsGameId,
                            NULL as betsDeskripsi,
                            NULL as betsCredit,
                            created_at,
                            NULL as betsProviderName,
                            NULL as betsTogelHistoryId,
                            NULL as betsTogelHistoryPasaran,
                            NULL as betsTogelHistorDeskripsi,
                            NULL as betsTogelHistoryDebit,
                            NULL as betsTogelHistoryKredit,
                            NULL as betsTogelHistoryBalance,
                            NULL as betsTogelHistoryCreatedBy,
                            IF(
                                deposit_id is not null
                                , credit
                                , NULL
                            ) AS depositCredit,
                            IF(
                                deposit_id is not null
                                , amount
                                , NULL
                            ) AS depositJumlah,
                            IF(
                                deposit_id is not null
                                , IF (
                                    status = 'Pending'
                                    , 0
                                    , IF (
                                        status = 'Approved'
                                        , 1
                                        , IF (
                                            status = 'Rejected'
                                            , 2
                                            , 3
                                        )
                                    )
                                )
                                , NULL
                            ) AS depositStatus,
                            IF(
                                deposit_id is not null
                                , IF (
                                    status = 'Approved'
                                    , 'Success'
                                    , status
                                )
                                , NULL
                            ) AS depositDescription,
                            IF(
                                withdraw_id is not null
                                , credit
                                , NULL
                            ) AS withdrawCredit,
                            IF(
                                withdraw_id is not null
                                , amount
                                , NULL
                            ) AS withdrawJumlah,
                            IF(
                                withdraw_id is not null
                                , IF (
                                    status = 'Pending'
                                    , 0
                                    , IF (
                                        status = 'Approved'
                                        , 1
                                        , IF (
                                            status = 'Rejected'
                                            , 2
                                            , 3
                                        )
                                    )
                                )
                                , NULL
                            ) AS withdrawStatus,
                            IF(
                                withdraw_id is not null
                                , IF (
                                    status = 'Approved'
                                    , 'Success'
                                    , status
                                )
                                , NULL
                            ) AS withdrawDescription,
                            NULL as bonusHistoryNamaBonus,
                            NULL as bonusHistoryType,
                            NULL as bonusHistoryJumlah,
                            NULL as bonusHistoryHadiah,
                            NULL as bonusHistoryStatus,
                            NULL as bonusHistoryCredit,
                            NULL as activityDeskripsi,
                            NULL as activityName,
                            NULL as detail
                            FROM
                            deposit_withdraw_history
                        WHERE
                            member_id = $id
                            AND created_at BETWEEN '$conditionDate' AND '$toDate'
                        ORDER BY
                            created_at
                        DESC");

                    $allProBet = array_merge($depoWithdrawHistory, $depositWithdraw);

                } else {
                    $allProBet = DB::select("SELECT
                            IF(
                                deposit_id is null
                                , 'Withdraw'
                                , 'Deposit'
                            ) AS Tables,
                            NULL as betsBet,
                            NULL as betsWin,
                            NULL as betsGameInfo,
                            NULL as betsBetId,
                            NULL as betsGameId,
                            NULL as betsDeskripsi,
                            NULL as betsCredit,
                            created_at,
                            NULL as betsProviderName,
                            NULL as betsTogelHistoryId,
                            NULL as betsTogelHistoryPasaran,
                            NULL as betsTogelHistorDeskripsi,
                            NULL as betsTogelHistoryDebit,
                            NULL as betsTogelHistoryKredit,
                            NULL as betsTogelHistoryBalance,
                            NULL as betsTogelHistoryCreatedBy,
                            IF(
                                deposit_id is not null
                                , credit
                                , NULL
                            ) AS depositCredit,
                            IF(
                                deposit_id is not null
                                , amount
                                , NULL
                            ) AS depositJumlah,
                            IF(
                                deposit_id is not null
                                , IF (
                                    status = 'Pending'
                                    , 0
                                    , IF (
                                        status = 'Approved'
                                        , 1
                                        , IF (
                                            status = 'Rejected'
                                            , 2
                                            , 3
                                        )
                                    )
                                )
                                , NULL
                            ) AS depositStatus,
                            IF(
                                deposit_id is not null
                                , IF (
                                    status = 'Approved'
                                    , 'Success'
                                    , status
                                )
                                , NULL
                            ) AS depositDescription,
                            IF(
                                withdraw_id is not null
                                , credit
                                , NULL
                            ) AS withdrawCredit,
                            IF(
                                withdraw_id is not null
                                , amount
                                , NULL
                            ) AS withdrawJumlah,
                            IF(
                                withdraw_id is not null
                                , IF (
                                    status = 'Pending'
                                    , 0
                                    , IF (
                                        status = 'Approved'
                                        , 1
                                        , IF (
                                            status = 'Rejected'
                                            , 2
                                            , 3
                                        )
                                    )
                                )
                                , NULL
                            ) AS withdrawStatus,
                            IF(
                                withdraw_id is not null
                                , IF (
                                    status = 'Approved'
                                    , 'Success'
                                    , status
                                )
                                , NULL
                            ) AS withdrawDescription,
                            NULL as bonusHistoryNamaBonus,
                            NULL as bonusHistoryType,
                            NULL as bonusHistoryJumlah,
                            NULL as bonusHistoryHadiah,
                            NULL as bonusHistoryStatus,
                            NULL as bonusHistoryCredit,
                            NULL as activityDeskripsi,
                            NULL as activityName,
                            NULL as detail
                        FROM
                            deposit_withdraw_history
                        WHERE
                            member_id = $id
                            AND created_at BETWEEN '$fromDate' AND '$toDate'
                        ORDER BY
                            created_at
                        DESC");
                }

                # Histori Login/Logout
                $activity_members = DB::select("SELECT
                                properties,
                                created_at
                            FROM
                                activity_log
                            WHERE
                                log_name = 'Member Login'
                                OR log_name ='Member Log Out'
                                AND created_at BETWEEN '$fromDate' AND '$toDate'
                            ");
                $properties = [];
                foreach ($activity_members as $activity) {
                    $array = json_decode($activity->properties, true);
                    if (!array_key_exists('device', $array) && !array_key_exists('created_at', $array)) {
                        $device = Arr::add($array, 'device', 'Unknown');
                        $properties[] = Arr::add($device, 'created_at', $activity->created_at);
                    } else {
                        $properties[] = Arr::add($array, 'created_at', $activity->created_at);
                    }
                };

                $member = MembersModel::where('id', auth('api')->user()->id)->first();
                $activity = [];
                $filterDate = collect($properties)->whereBetween('created_at', [$fromDate, $toDate])->all();
                foreach ($filterDate as $index => $json) {
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
                        'bonusHistoryStatus' => null,
                        'bonusHistoryCredit' => null,
                        'activityDeskripsi' => $value['device'] != null ? $value['activity'] . " : " . $value['device'] : $value['activity'],
                        'activityName' => $value['device'] != null ? $value['activity'] . " - " . $value['device'] : $value['activity'],
                        'detail' => null,
                    ];
                    $activitys[] = $activity;
                };

                # History Bets Togel
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
                        'betsTogelHistorDeskripsi' => 'Bet : (' . $value['Game'] . ' => ' . $value['Nomor'] . ')',
                        'betsTogelHistoryDebit' => $value['winTogel'],
                        'betsTogelHistoryKredit' => $value['Bayar'],
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
                        'bonusHistoryStatus' => null,
                        'bonusHistoryCredit' => null,
                        'activityDeskripsi' => null,
                        'activityName' => null,
                        'detail' => '/endpoint/getDetailTransaksiTogel/' . $value['id'],
                    ];
                    $betTogelHistories[] = $betTogelHis;
                }

                # History Bonus
                $bonusHistory = [];
                foreach ($bonus->get() as $key => $value) {
                    $status_bonus = preg_match("/menyerah/i", $value->hadiah) ? 'Menyerah' : (preg_match("/mendapatkan/i", $value->hadiah) ? 'Klaim' : (preg_match("/gagal/i", $value->hadiah) ? 'Gagal' : (preg_match("/batalkan/i", $value->hadiah) ? 'Cancel' : 'Klaim')));

                    $bonusHistory[] = [
                        'Tables' => 'Bonus History',
                        'betsBet' => null,
                        'betsWin' => null,
                        'betsGameInfo' => null,
                        'betsBetId' => null,
                        'betsGameId' => null,
                        'betsDeskripsi' => null,
                        'betsCredit' => null,
                        'created_at' => $value->created_at,
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
                        'bonusHistoryNamaBonus' => $value->nama_bonus,
                        'bonusHistoryType' => $value->type,
                        'bonusHistoryJumlah' => $value->jumlah,
                        'bonusHistoryHadiah' => $value->hadiah,
                        'bonusHistoryStatus' => $status_bonus,
                        'bonusHistoryCredit' => $value->credit,
                        'activityDeskripsi' => null,
                        'activityName' => null,
                        'detail' => null,
                    ];
                }

                $referalMembers = MembersModel::select('id')->where('id', $id)
                    ->with([
                        'referrals' => function ($query) use ($fromDate, $toDate) {
                            $query->with([
                                'betTogels' => function ($query) use ($fromDate, $toDate) {
                                    $query->selectRaw("created_by, id as bet_id, bonus_daily_referal, balance_upline_referral, created_at")->where('bonus_daily_referal', '>', 0)->whereBetween('created_at', [$fromDate, $toDate])->orderBy('created_at', 'desc');
                                },
                                'bets' => function ($query) use ($fromDate, $toDate) {
                                    $query->selectRaw("constant_provider_id, created_by, game_id as bet_id, bonus_daily_referal, credit_upline_referral, created_at")->where('bonus_daily_referal', '>', 0)->whereBetween('created_at', [$fromDate, $toDate])->orderBy('created_at', 'desc');
                                },
                            ])->select(['referrer_id', 'id', 'username']);
                        }])->first()->toArray();
                # History Togel Referral
                $togelReferals = [];
                foreach ($referalMembers['referrals'] as $key => $item) {
                    if ($item['bet_togels'] != []) {
                        foreach ($item['bet_togels'] as $value) {
                            $togelReferals[] = [
                                'Tables' => 'bonus Referral',
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
                                'betsTogelHistorDeskripsi' => 'Dari downline referal Anda ' . $item['username'] . ' bermain Togel',
                                'betsTogelHistoryDebit' => null,
                                'betsTogelHistoryKredit' => $value['bonus_daily_referal'],
                                'betsTogelHistoryBalance' => $value['balance_upline_referral'],
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
                                'bonusHistoryStatus' => null,
                                'bonusHistoryCredit' => null,
                                'activityDeskripsi' => null,
                                'activityName' => null,
                                'detail' => null,
                            ];
                        }
                    }
                }

                # History Pragmatic Slot Referral
                $PragmaticSlotReferal = [];
                foreach ($referalMembers['referrals'] as $key => $item) {
                    if ($item['bets'] != []) {
                        $PragmaticSlot = collect($item['bets'])->where('constant_provider_id', 1)->all();
                        foreach ($PragmaticSlot as $value) {
                            $PragmaticSlotReferal[] = [
                                'Tables' => 'bonus Referral',
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
                                'betsTogelHistorDeskripsi' => 'Dari downline referal Anda ' . $item['username'] . ' bermain Pragmatic Slot',
                                'betsTogelHistoryDebit' => null,
                                'betsTogelHistoryKredit' => $value['bonus_daily_referal'],
                                'betsTogelHistoryBalance' => $value['credit_upline_referral'],
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
                                'bonusHistoryStatus' => null,
                                'bonusHistoryCredit' => null,
                                'activityDeskripsi' => null,
                                'activityName' => null,
                                'detail' => null,
                            ];
                        }
                    }
                }

                # History Pragmatic Live Casino Referral
                $PragmaticLiveCasinoReferal = [];
                foreach ($referalMembers['referrals'] as $key => $value) {
                    if ($item['bets'] != []) {
                        $PragmaticLiveCasino = collect($item['bets'])->where('constant_provider_id', 10)->all();
                        foreach ($PragmaticLiveCasino as $value) {
                            $PragmaticLiveCasinoReferal[] = [
                                'Tables' => 'bonus Referral',
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
                                'betsTogelHistorDeskripsi' => 'Dari downline referal Anda ' . $item['username'] . ' bermain Pragmatic Live Casino',
                                'betsTogelHistoryDebit' => null,
                                'betsTogelHistoryKredit' => $value['bonus_daily_referal'],
                                'betsTogelHistoryBalance' => $value['credit_upline_referral'],
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
                                'bonusHistoryStatus' => null,
                                'bonusHistoryCredit' => null,
                                'activityDeskripsi' => null,
                                'activityName' => null,
                                'detail' => null,
                            ];
                        }

                    }
                }

                # History Habanero Slot Referral
                $HabaneroSlotReferal = [];
                foreach ($referalMembers['referrals'] as $key => $value) {
                    if ($item['bets'] != []) {
                        $HabaneroSlot = collect($item['bets'])->where('constant_provider_id', 2)->all();
                        foreach ($HabaneroSlot as $value) {
                            $HabaneroSlotReferal[] = [
                                'Tables' => 'bonus Referral',
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
                                'betsTogelHistorDeskripsi' => 'Dari downline referal Anda ' . $item['username'] . ' bermain Habanero Slot',
                                'betsTogelHistoryDebit' => null,
                                'betsTogelHistoryKredit' => $value['bonus_daily_referal'],
                                'betsTogelHistoryBalance' => $value['credit_upline_referral'],
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
                                'bonusHistoryStatus' => null,
                                'bonusHistoryCredit' => null,
                                'activityDeskripsi' => null,
                                'activityName' => null,
                                'detail' => null,
                            ];
                        }
                    }
                }

                # History Joker Slot Referral
                $JokerSlotReferal = [];
                foreach ($referalMembers['referrals'] as $key => $value) {
                    if ($item['bets'] != []) {
                        $JokerSlot = collect($item['bets'])->where('constant_provider_id', 3)->all();
                        foreach ($JokerSlot as $value) {
                            $JokerSlotReferal[] = [
                                'Tables' => 'bonus Referral',
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
                                'betsTogelHistorDeskripsi' => 'Dari downline referal Anda ' . $item['username'] . ' bermain Joker Slot',
                                'betsTogelHistoryDebit' => null,
                                'betsTogelHistoryKredit' => $value['bonus_daily_referal'],
                                'betsTogelHistoryBalance' => $value['credit_upline_referral'],
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
                                'bonusHistoryStatus' => null,
                                'bonusHistoryCredit' => null,
                                'activityDeskripsi' => null,
                                'activityName' => null,
                                'detail' => null,
                            ];
                        }
                    }
                }
                # History Joker Fish Referral
                $JokerFishReferal = [];
                foreach ($referalMembers['referrals'] as $key => $value) {
                    if ($item['bets'] != []) {
                        $JokerFish = collect($item['bets'])->where('constant_provider_id', 13)->all();
                        foreach ($JokerFish as $value) {
                            $JokerFishReferal[] = [
                                'Tables' => 'bonus Referral',
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
                                'betsTogelHistorDeskripsi' => 'Dari downline referal Anda ' . $item['username'] . ' bermain Joker Fish',
                                'betsTogelHistoryDebit' => null,
                                'betsTogelHistoryKredit' => $value['bonus_daily_referal'],
                                'betsTogelHistoryBalance' => $value['credit_upline_referral'],
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
                                'bonusHistoryStatus' => null,
                                'bonusHistoryCredit' => null,
                                'activityDeskripsi' => null,
                                'activityName' => null,
                                'detail' => null,
                            ];
                        }
                    }
                }
                # History Spade Slot Referral
                $SpadeSlotReferal = [];
                foreach ($referalMembers['referrals'] as $key => $value) {
                    if ($item['bets'] != []) {
                        $SpadeSlot = collect($item['bets'])->where('constant_provider_id', 4)->all();
                        foreach ($SpadeSlot as $value) {
                            $SpadeSlotReferal[] = [
                                'Tables' => 'bonus Referral',
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
                                'betsTogelHistorDeskripsi' => 'Dari downline referal Anda ' . $item['username'] . ' bermain Spade Slot',
                                'betsTogelHistoryDebit' => null,
                                'betsTogelHistoryKredit' => $value['bonus_daily_referal'],
                                'betsTogelHistoryBalance' => $value['credit_upline_referral'],
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
                                'bonusHistoryStatus' => null,
                                'bonusHistoryCredit' => null,
                                'activityDeskripsi' => null,
                                'activityName' => null,
                                'detail' => null,
                            ];
                        }
                    }
                }
                # History Spade Fish Referral
                $SpadeFishReferal = [];
                foreach ($referalMembers['referrals'] as $key => $value) {
                    if ($item['bets'] != []) {
                        $SpadeFish = collect($item['bets'])->where('constant_provider_id', 14)->all();
                        foreach ($SpadeFish as $value) {
                            $SpadeFishReferal[] = [
                                'Tables' => 'bonus Referral',
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
                                'betsTogelHistorDeskripsi' => 'Dari downline referal Anda ' . $item['username'] . ' bermain Spade Fish',
                                'betsTogelHistoryDebit' => null,
                                'betsTogelHistoryKredit' => $value['bonus_daily_referal'],
                                'betsTogelHistoryBalance' => $value['credit_upline_referral'],
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
                                'bonusHistoryStatus' => null,
                                'bonusHistoryCredit' => null,
                                'activityDeskripsi' => null,
                                'activityName' => null,
                                'detail' => null,
                            ];
                        }
                    }
                }
                # History PGSoft Slot Referral
                $PGSoftSlotReferal = [];
                foreach ($referalMembers['referrals'] as $key => $value) {
                    if ($item['bets'] != []) {
                        $PGSoftSlot = collect($item['bets'])->where('constant_provider_id', 5)->all();
                        foreach ($PGSoftSlot as $value) {
                            $PGSoftSlotReferal[] = [
                                'Tables' => 'bonus Referral',
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
                                'betsTogelHistorDeskripsi' => 'Dari downline referal Anda ' . $item['username'] . ' bermain PGSoft Slot',
                                'betsTogelHistoryDebit' => null,
                                'betsTogelHistoryKredit' => $value['bonus_daily_referal'],
                                'betsTogelHistoryBalance' => $value['credit_upline_referral'],
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
                                'bonusHistoryStatus' => null,
                                'bonusHistoryCredit' => null,
                                'activityDeskripsi' => null,
                                'activityName' => null,
                                'detail' => null,
                            ];
                        }
                    }
                }
                # History JDB Slot Referral
                $JDBSlotReferal = [];
                foreach ($referalMembers['referrals'] as $key => $value) {
                    if ($item['bets'] != []) {
                        $JDBSlot = collect($item['bets'])->where('constant_provider_id', 7)->all();
                        foreach ($JDBSlot as $value) {
                            $JDBSlotReferal[] = [
                                'Tables' => 'bonus Referral',
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
                                'betsTogelHistorDeskripsi' => 'Dari downline referal Anda ' . $item['username'] . ' bermain JDB Slot',
                                'betsTogelHistoryDebit' => null,
                                'betsTogelHistoryKredit' => $value['bonus_daily_referal'],
                                'betsTogelHistoryBalance' => $value['credit_upline_referral'],
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
                                'bonusHistoryStatus' => null,
                                'bonusHistoryCredit' => null,
                                'activityDeskripsi' => null,
                                'activityName' => null,
                                'detail' => null,
                            ];
                        }
                    }
                }
                # History JDB Fish Referral
                $JDBFishReferal = [];
                foreach ($referalMembers['referrals'] as $key => $value) {
                    if ($item['bets'] != []) {
                        $JDBFish = collect($item['bets'])->where('constant_provider_id', 15)->all();
                        foreach ($JDBFish as $value) {
                            $JDBFishReferal[] = [
                                'Tables' => 'bonus Referral',
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
                                'betsTogelHistorDeskripsi' => 'Dari downline referal Anda ' . $item['username'] . ' bermain JDB Fish',
                                'betsTogelHistoryDebit' => null,
                                'betsTogelHistoryKredit' => $value['bonus_daily_referal'],
                                'betsTogelHistoryBalance' => $value['credit_upline_referral'],
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
                                'bonusHistoryStatus' => null,
                                'bonusHistoryCredit' => null,
                                'activityDeskripsi' => null,
                                'activityName' => null,
                                'detail' => null,
                            ];
                        }
                    }
                }
                # History Sexy Gaming Live Casino Referral
                $SexyGamingLiveCasinoReferal = [];
                foreach ($referalMembers['referrals'] as $key => $value) {
                    if ($item['bets'] != []) {
                        $SexyGamingLiveCasino = collect($item['bets'])->where('constant_provider_id', 11)->all();
                        foreach ($SexyGamingLiveCasino as $value) {
                            $SexyGamingLiveCasinoReferal[] = [
                                'Tables' => 'bonus Referral',
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
                                'betsTogelHistorDeskripsi' => 'Dari downline referal Anda ' . $item['username'] . ' bermain Sexy Gaming Live Casino',
                                'betsTogelHistoryDebit' => null,
                                'betsTogelHistoryKredit' => $value['bonus_daily_referal'],
                                'betsTogelHistoryBalance' => $value['credit_upline_referral'],
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
                                'bonusHistoryStatus' => null,
                                'bonusHistoryCredit' => null,
                                'activityDeskripsi' => null,
                                'activityName' => null,
                                'detail' => null,
                            ];
                        }
                    }
                }
                # History IONX Live Casino Referral
                $IONXLiveCasinoReferal = [];
                foreach ($referalMembers['referrals'] as $key => $value) {
                    if ($item['bets'] != []) {
                        $IONXLiveCasino = collect($item['bets'])->where('constant_provider_id', 8)->all();
                        foreach ($IONXLiveCasino as $value) {
                            $IONXLiveCasinoReferal[] = [
                                'Tables' => 'bonus Referral',
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
                                'betsTogelHistorDeskripsi' => 'Dari downline referal Anda ' . $item['username'] . ' bermain IONX Live Casino',
                                'betsTogelHistoryDebit' => null,
                                'betsTogelHistoryKredit' => $value['bonus_daily_referal'],
                                'betsTogelHistoryBalance' => $value['credit_upline_referral'],
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
                                'bonusHistoryStatus' => null,
                                'bonusHistoryCredit' => null,
                                'activityDeskripsi' => null,
                                'activityName' => null,
                                'detail' => null,
                            ];
                        }
                    }
                }
                # History One Game Slot Referral
                $OneGameSlotReferal = [];
                foreach ($referalMembers['referrals'] as $key => $value) {
                    if ($item['bets'] != []) {
                        $OneGameSlot = collect($item['bets'])->where('constant_provider_id', 9)->all();
                        foreach ($OneGameSlot as $value) {
                            $OneGameSlotReferal[] = [
                                'Tables' => 'bonus Referral',
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
                                'betsTogelHistorDeskripsi' => 'Dari downline referal Anda ' . $item['username'] . ' bermain One Game Slot',
                                'betsTogelHistoryDebit' => null,
                                'betsTogelHistoryKredit' => $value['bonus_daily_referal'],
                                'betsTogelHistoryBalance' => $value['credit_upline_referral'],
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
                                'bonusHistoryStatus' => null,
                                'bonusHistoryCredit' => null,
                                'activityDeskripsi' => null,
                                'activityName' => null,
                                'detail' => null,
                            ];
                        }
                    }
                }
                # History Red Tiger Slot Referral
                $RedTigerSlotReferal = [];
                foreach ($referalMembers['referrals'] as $key => $value) {
                    if ($item['bets'] != []) {
                        $RedTigerSlot = collect($item['bets'])->where('constant_provider_id', 12)->all();
                        foreach ($RedTigerSlot as $value) {
                            $RedTigerSlotReferal[] = [
                                'Tables' => 'bonus Referral',
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
                                'betsTogelHistorDeskripsi' => 'Dari downline referal Anda ' . $item['username'] . ' bermain Red Tiger Slot',
                                'betsTogelHistoryDebit' => null,
                                'betsTogelHistoryKredit' => $value['bonus_daily_referal'],
                                'betsTogelHistoryBalance' => $value['credit_upline_referral'],
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
                                'bonusHistoryStatus' => null,
                                'bonusHistoryCredit' => null,
                                'activityDeskripsi' => null,
                                'activityName' => null,
                                'detail' => null,
                            ];
                        }
                    }
                }

                # Combine all history
                $alldata = array_merge($providers, $allProBet, $activitys, $bonusHistory, $betTogelHistories, $togelReferals, $PragmaticSlotReferal, $PragmaticLiveCasinoReferal, $HabaneroSlotReferal, $JokerSlotReferal, $JokerFishReferal, $SpadeSlotReferal, $SpadeFishReferal, $PGSoftSlotReferal, $JDBSlotReferal, $JDBFishReferal, $SexyGamingLiveCasinoReferal, $IONXLiveCasinoReferal, $OneGameSlotReferal, $RedTigerSlotReferal);
                $date = array_column($alldata, 'created_at');
                array_multisort($date, SORT_DESC, $alldata);
                $this->allProviderBet = $alldata;

                $allProviderBet = $this->paginate($this->allProviderBet, $this->pageAll);
                return [
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
        $fromDate = Carbon::now()->subMonth(2)->format('Y-m-d 00:00:00');
        $toDate = Carbon::now();

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
                  , SUM(bets_togel.bet_amount) as 'Bet'
                  , SUM(bets_togel.pay_amount) as 'Bayar'
                  , SUM(bets_togel.win_nominal) as 'winTogel'
                  , CONCAT(REPLACE(FORMAT(bets_togel.tax_amount,1),',',-1), '%') as 'discKei'


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
            ->whereBetween('bets_togel.created_at', [$fromDate, $toDate])
            ->where('bets_togel.created_by', '=', auth('api')->user()->id)
            ->orderBy('bets_togel.id', 'DESC')
            ->groupBy('bets_togel.togel_game_id')
            ->groupBy(DB::raw("DATE_FORMAT(bets_togel.created_at, '%Y-%m-%d %H:%i')"))
            ->get();

        return $this->togel = collect($result)->map(function ($value) {
            return [
                'created_at' => $value->created_at,
                'bets_togel_id' => $value->id,
                'pasaran' => $value->Pasaran,
                'description' => 'Bet : ' . $value->Game,
                'debit' => $value->winTogel, #win
                'kredit' => $value->Bayar, #pay amount
                'balance' => $value->balance,
                'created_by' => auth('api')->user()->username,
                // 'url'       => "/endpoint/getDetailTransaksi?detail=$value->id",
                'url' => '/endpoint/getDetailTransaksiTogel/' . $value->id,
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

        $fromDate = Carbon::now()->subMonth(2)->format('Y-m-d 00:00:00');
        $toDate = Carbon::now();

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
            , SUM(bets_togel.bet_amount) as 'Bet'
            , SUM(bets_togel.pay_amount) as 'Bayar'
            , SUM(bets_togel.win_nominal) as 'winTogel'
            , CONCAT(REPLACE(FORMAT(bets_togel.tax_amount,1),',',-1), '%') as 'discKei'


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
            ->whereBetween('bets_togel.created_at', [$fromDate, $toDate])
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
            ->where('bets_togel.created_by', $date->created_by)
            ->where('bets_togel.togel_game_id', $date->togel_game_id)->get()->toArray();
        return $result;
    }

    public function __construct()
    {
        $this->member = auth('api')->user();
    }

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
            # Last Deposit
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

            # Last Withdraw
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

                return $this->successResponse($response);
            } else {
                return $this->successResponse(null, 'Tidak ada konten', 204);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException$e) {
            return $this->errorResponse('Token expired', 404);
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException$e) {
            return $this->errorResponse('Token invalid', 400);
        } catch (Tymon\JWTAuth\Exceptions\JWTException$e) {
            return $this->errorResponse('Token absent', 500);
        }
    }

    public function getStatement()
    {
        try {
            $date = Carbon::now()->subMonth(2);
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
            $date = Carbon::now()->subMonth(2);
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
                        'ip_member' => auth('api')->user()->last_login_ip,
                    ],
                    "{$user->name} Created a Rekening nama_rekening: $createRekMember->nama_rekening. nomor_rekening: $createRekMember->nomor_rekening"
                );
                // auth('api')->user()->update([
                //     'last_login_ip' => $request->ip,
                // ]);

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
                    'ip_member' => auth('api')->user()->last_login_ip,
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
            // auth('api')->user()->update([
            //     'last_login_ip' => $request->ip,
            // ]);
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
            $bankAgent = RekMemberModel::leftJoin('constant_rekening', 'constant_rekening.id', '=', 'rek_member.constant_rekening_id')
                ->join('rekening', 'rekening.id', 'rek_member.rekening_id')
                ->select([
                    'rekening.id',
                    'rekening.nama_rekening',
                    'rekening.nomor_rekening',
                    'rekening.path as qrcode',
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
                    'rekening.path as qrcode',
                    'constant_rekening.name',
                ])
                ->where('is_default', 1)
                ->where('is_none', 0)
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
                $data[] = ["togel" => $bonus];
                $data[] = ["slot" => ConstantProvider::select('constant_provider_name', 'value')->whereIn('id', [1, 2, 3, 4, 5, 7, 9, 12])->get()];
                $data[] = ["tembak_ikan" => ConstantProvider::select('constant_provider_name', 'value')->whereIn('id', [13, 14, 15])->get()];
                $data[] = ["live_casino" => ConstantProvider::select('constant_provider_name', 'value')->whereIn('id', [8, 10, 11])->get()];
                return $this->successResponse($data, 'Bonus referal', 200);
            }
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 500);
        }
    }

    // pagination
    public function paginate($items, $perPage, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
