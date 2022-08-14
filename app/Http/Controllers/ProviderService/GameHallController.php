<?php

namespace App\Http\Controllers\ProviderService;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BonusModel;
use App\Models\ConstantProvider;
use App\Models\UploadBonusModel;
use Firebase\JWT\JWT;
use App\Models\MembersModel;
use App\Models\BetModel;
use App\Models\UserLogModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class GameHallController extends Controller
{
  // Token From Casino Provider
  protected string $token;

  // ratio for slot
  protected int $ratio = 1000;

  // this As Object From Token Decoded
  protected object $transaction;

  protected string $betTime;

  // Before this Controller is called, we need to check if the user is logged in
  public function __construct()
  {

    $this->token =  request()->token;
    $this->transaction = JWT::decode($this->token, 'diosjiodAJSDIOJIOsdiojaoijASDJ', array('HS256'));
  }

  // public function getBalance(Request $request)
  // {
  //   try {      
  //     $this->token = $request->token;
  //     $decoded = JWT::decode($this->token, 'diosjiodAJSDIOJIOsdiojaoijASDJ', array('HS256'));
  //     $userId = preg_replace("/[^0-9]/","", $decoded->userId);
  //     $member = MembersModel::where('id', $userId)->first();
      
  //     if (substr($decoded->userId, -3) == "pti") {
  //       $res = [
  //         "status" => "0000",
  //         "userId" => $decoded->userId,
  //         "balance" => $member->credit
  //       ];
  //     } else {
  //       $res = [
  //         "status" => "0000",
  //         "userId" => $decoded->userId,
  //         "balance" => (string)round($member->credit/1000, 3)
  //       ];
  //     }

  //     return Response::json($res);

  //   } catch (\Throwable $th) {
  //     return response()->json($th->getMessage(), 500);
  //   }
  // }

  // Listen Transaction From Decoded Token
  public function listenTransaction()
  {
    $action = $this->transaction->action;

    switch ($action) {
      case 'bet':
        return $this->Bet();
        break;

      case 'settle':
        return $this->Settle();
        break;

      case 'betNSettle':
        return $this->BetNSettle();
        break;

      case 'cancelBetNSettle':
        return $this->CancelBetNSettle();
        break;

      case 'freeSpin':
        return $this->FreeSpin();
        break;

      case 'unsettle':
        return $this->UnSettle();
        break;

      case 'cancelBet':
        return $this->CancelBet();
        break;

      case 'adjustBet':
        return $this->AdjustBet();
        break;

        //this is duplicated
      // case 'adjustBet':
      //   return $this->AdjustBet();
      //   break;

      case 'voidBet':
        return $this->VoidBet();
        break;

      case 'voidSettle':
        return $this->VoidSettle();
        break;

      case 'unvoidSettle':
        return $this->UnVoidSettle();
        break;

      case 'refund':
        return $this->RefunBet();
        break;

      case 'unvoidBet':
        return $this->UnVoidBet();
        break;

      case 'tip':
        return $this->Tip();
        break;

      case 'give':
        return $this->Give();
        break;

      case 'cancelTip':
        return $this->CancelTip();
        break;
    }
    return response()->json([
      'status' => 'error',
      'message' => 'Action not found'
    ]);
  }


  public function Bet()
  {
    // call betInformation
    $token = $this->betInformation();
    $datas;
    foreach ($token->data->txns as $tokenRaw) {
      $member =  MembersModel::where('id', $tokenRaw->userId)->first();
      $amountbet = $tokenRaw->betAmount;
      $creditMember = $member->credit;
      $amount = $creditMember - $amountbet;
      $this->betTime = $tokenRaw->betTime;
      if ($creditMember < $amountbet) {
        return response()->json([
          "status" => '1018',
          "balance" => intval($creditMember),
          "balanceTs"   => now()->format("Y-m-d\TH:i:s.vP")
          ]);
      } else {
        // check if bet already exist
        $BetAlready = BetModel::where('bet_id', '=', $tokenRaw->platformTxId)
                        ->where('platform', $tokenRaw->platform)->where('type', 'Bet')->first();
        $betAfterCancel = BetModel::where('bet_id', '=', $tokenRaw->platformTxId)
                        ->where('platform', $tokenRaw->platform)->where('type', 'Cancel')->first();

        if ($BetAlready || $betAfterCancel) {
          $data = [
            "status" => '0000',
            "balance" => intval($creditMember),
            "balanceTs"   => now()->format("Y-m-d\TH:i:s.vP")
          ];
          $datas = $data;
        } else {
          if (count($token->data->txns) < 2) {
            // update credit to table member
            $member->update([
              'credit' => $amount,
              'updated_at' => Carbon::now(),
            ]);

            $bets = BetModel::create([
              'platform'  => $tokenRaw->platform,
              'created_by' => $tokenRaw->userId,
              'bet_id' => $tokenRaw->platformTxId,
              'game_info' => 'live_casino',
              'game_id' => $tokenRaw->gameCode,
              'round_id' => $tokenRaw->roundId,
              'type' => 'Bet',
              'game' => $tokenRaw->gameName,
              'bet' => $amountbet,
              'credit' => $amount,
              'created_at' => Carbon::now(),
              'constant_provider_id' => 11,
              'deskripsi' => 'Game Bet' . ' : ' . $amountbet,
            ]);

            $nameProvider = BetModel::leftJoin('constant_provider', 'constant_provider.id', '=', 'bets.constant_provider_id')
                ->leftJoin('members', 'members.id', '=', 'bets.created_by')
                ->where('bets.id', $bets->id)->first();
            $member =  MembersModel::where('id', $bets->created_by)->first();

            UserLogModel::logMemberActivity(
              'create bet',
              $member,
              $bets,
              [
                'target' => $nameProvider->username,
                'activity' => 'Bet',
                'device' => $nameProvider->device,
                'ip' => $nameProvider->last_login_ip,
              ],
              "$nameProvider->username . ' Bet on ' . $nameProvider->constant_provider_name . ' type ' .  $bets->game_info . ' idr '. $nameProvider->bet"
            );

            $data = [
              "status" => '0000',
              "balance" => intval($amount),
              "balanceTs"   => now()->format("Y-m-d\TH:i:s.vP")
            ];
            $datas = $data;
          } else {
            $checkMulti = BetModel::selectRaw('Count(id) as total, created_at')->where('created_by', $tokenRaw->userId)
                          ->where('platform', $tokenRaw->platform)->where('type', 'Bet')->whereDate('created_at', now())
                          ->orderBy('created_at', 'desc')->groupBy('created_at')->first();
            if ($checkMulti === null) {
              // update credit to table member
              $member->update([
                'credit' => $amount,
                'updated_at' => Carbon::now(),
              ]);

              $bets = BetModel::create([
                'platform'  => $tokenRaw->platform,
                'created_by' => $tokenRaw->userId,
                'bet_id' => $tokenRaw->platformTxId,
                'game_info' => 'live_casino',
                'game_id' => $tokenRaw->gameCode,
                'round_id' => $tokenRaw->roundId,
                'type' => 'Bet',
                'game' => $tokenRaw->gameName,
                'bet' => $amountbet,
                'credit' => $amount,
                'created_at' => Carbon::now(),
                'constant_provider_id' => 11,
                'deskripsi' => 'Game Bet' . ' : ' . $amountbet,
              ]);

              $nameProvider = BetModel::leftJoin('constant_provider', 'constant_provider.id', '=', 'bets.constant_provider_id')
                  ->leftJoin('members', 'members.id', '=', 'bets.created_by')
                  ->where('bets.id', $bets->id)->first();
              $member =  MembersModel::where('id', $bets->created_by)->first();

              UserLogModel::logMemberActivity(
                'create bet',
                $member,
                $bets,
                [
                  'target' => $nameProvider->username,
                  'activity' => 'Bet',
                  'device' => $nameProvider->device,
                  'ip' => $nameProvider->last_login_ip,
                ],
                "$nameProvider->username . ' Bet on ' . $nameProvider->constant_provider_name . ' type ' .  $bets->game_info . ' idr '. $nameProvider->bet"
              );

              $data = [
                "status" => '0000',
                "balance" => intval($amount),
                "balanceTs"   => now()->format("Y-m-d\TH:i:s.vP")
              ];
              $datas = $data;
            } elseif ($checkMulti->total >= 46) {
              $data = [
                "status" => '0000',
                "balance" => intval($creditMember),
                "balanceTs"   => now()->format("Y-m-d\TH:i:s.vP")
              ];
              $datas = $data;
            } else {
              // update credit to table member
              $member->update([
                'credit' => $amount,
                'updated_at' => Carbon::now(),
              ]);

              $bets = BetModel::create([
                'platform'  => $tokenRaw->platform,
                'created_by' => $tokenRaw->userId,
                'bet_id' => $tokenRaw->platformTxId,
                'game_info' => 'live_casino',
                'game_id' => $tokenRaw->gameCode,
                'round_id' => $tokenRaw->roundId,
                'type' => 'Bet',
                'game' => $tokenRaw->gameName,
                'bet' => $amountbet,
                'credit' => $amount,
                'created_at' => Carbon::now(),
                'constant_provider_id' => 11,
                'deskripsi' => 'Game Bet' . ' : ' . $amountbet,
              ]);

              $nameProvider = BetModel::leftJoin('constant_provider', 'constant_provider.id', '=', 'bets.constant_provider_id')
                  ->leftJoin('members', 'members.id', '=', 'bets.created_by')
                  ->where('bets.id', $bets->id)->first();
              $member =  MembersModel::where('id', $bets->created_by)->first();

              UserLogModel::logMemberActivity(
                'create bet',
                $member,
                $bets,
                [
                  'target' => $nameProvider->username,
                  'activity' => 'Bet',
                  'device' => $nameProvider->device,
                  'ip' => $nameProvider->last_login_ip,
                ],
                "$nameProvider->username . ' Bet on ' . $nameProvider->constant_provider_name . ' type ' .  $bets->game_info . ' idr '. $nameProvider->bet"
              );

              $data = [
                "status" => '0000',
                "balance" => intval($amount),
                "balanceTs"   => now()->format("Y-m-d\TH:i:s.vP")
              ];
              $datas = $data;
            }
          }
        }
      }
    }
    return response()->json($datas, 200);
  }

  // Get the information of the user
  protected function betInformation()
  {
    $data = $this->transaction;
    return (object)[
      "data" => $data,
    ];
  }

  public function CancelBet()
  {
    try {
      // call betInformation
      $token = $this->betInformation();
      $datas;
      foreach ($token->data->txns as $tokenRaw) {
        $member =  MembersModel::where('id', $tokenRaw->userId)->first();
        $creditMember = $member->credit;
        $bet = BetModel::where('bet_id', '=', $tokenRaw->platformTxId)
              ->where('platform', $tokenRaw->platform)->where('type', 'Cancel')->first();
        if ($bet) {
          $data = [
            "status" => '0000',
            "balance" => $member->credit,
            "balanceTs"   => Carbon::now()->format("Y-m-d\TH:i:s.vP")
          ];
          $datas = $data;
        } else {
          //update balance member
          $betBeforeCancel = BetModel::where('bet_id', '=', $tokenRaw->platformTxId)
                        ->where('platform', $tokenRaw->platform)->where('type', 'Bet')->first();
          if ($betBeforeCancel) {
            //update type bet
            BetModel::query()->where('bet_id', '=', $tokenRaw->platformTxId)
            ->where('platform', $tokenRaw->platform)
            ->update([
              'type' => 'Cancel'
            ]);
            //update balance member
            $betAfterCancel = BetModel::where('bet_id', '=', $tokenRaw->platformTxId)
                          ->where('platform', $tokenRaw->platform)->where('type', 'Cancel')->first();
            MembersModel::where('id', $tokenRaw->userId)->update([
                'credit' => $creditMember + $betAfterCancel->bet
            ]);
            $balanceUpdate =  MembersModel::where('id', $tokenRaw->userId)->first();
            $data = [
              "status" => '0000',
              "balance" => $balanceUpdate->credit,
              "balanceTs"   => Carbon::now()->format("Y-m-d\TH:i:s.vP")
            ];
            $datas = $data;
          } else {
            $betAfterCancel = BetModel::where('bet_id', '=', $tokenRaw->platformTxId)
                          ->where('platform', $tokenRaw->platform)->where('type', 'Cancel')->first();
            if ($betAfterCancel) {
              $bets = BetModel::create([
                'platform'  => $tokenRaw->platform,
                'created_by' => $tokenRaw->userId,
                'bet_id' => $tokenRaw->platformTxId,
                'game_info' => 'live_casino',
                'game_id' => $tokenRaw->gameCode,
                'round_id' => $tokenRaw->roundId,
                'credit' => $creditMember + $betAfterCancel->bet,
                'type' => 'Cancel',
                'bet' => 0,
                'created_at' => Carbon::now()->format("Y-m-d\TH:i:s.vP"),
                'constant_provider_id' => 11,
                'deskripsi' => 'Cancel bet before place bet' ,
              ]);
              $data = [
                "status" => '0000',
                "balance" => $creditMember,
                "balanceTs"   => Carbon::now()->format("Y-m-d\TH:i:s.vP")
              ];
              $datas = $data;
            } else {
              $bets = BetModel::create([
                'platform'  => $tokenRaw->platform,
                'created_by' => $tokenRaw->userId,
                'bet_id' => $tokenRaw->platformTxId,
                'game_info' => 'live_casino',
                'game_id' => $tokenRaw->gameCode,
                'round_id' => $tokenRaw->roundId,
                'credit' => $creditMember,
                'type' => 'Cancel',
                'bet' => 0,
                'created_at' => Carbon::now()->format("Y-m-d\TH:i:s.vP"),
                'constant_provider_id' => 11,
                'deskripsi' => 'Cancel bet only',
              ]);
              $data = [
                "status" => '0000',
                "balance" => $creditMember,
                "balanceTs"   => Carbon::now()->format("Y-m-d\TH:i:s.vP")
              ];
              $datas = $data;
            }
          }
        }
      }
      return response()->json($datas);
    } catch (\Throwable $th) {
      $data = [
        "status" => 'error',
        "message" => 'Internal Server Error',
      ];
      return response()->json($data, 500);
    }
  }

  public function VoidBet()
  {
    // call betInformation
    $token = $this->betInformation();
    $datas;
    foreach ($token->data->txns as $tokenRaw) {
      $amountbet = $tokenRaw->betAmount;

      $member =  MembersModel::where('id', $tokenRaw->userId)->first();
      $creditMember = $member->credit + $amountbet;      

      $CheckVoid = BetModel::query()->where('bet_id', $tokenRaw->platformTxId)
        ->where('platform', $tokenRaw->platform)
        ->where('type', 'Void')
        ->first();

      if($CheckVoid){
        return [
          "status" => '0000',
        ];
      }else {
        $bets = BetModel::query()->where('bet_id', $tokenRaw->platformTxId)
        ->where('platform', $tokenRaw->platform)
        ->where('type', 'Bet')
        ->first();
        $bets->update([
          'type' => 'Void',
          'bet' => $amountbet,
          'credit' => $creditMember,
          'updated_at' => Carbon::now(),
          // 'updated_at' => $tokenRaw->updateTime,
        ]);
        $member->update([
          'credit' => $creditMember
        ]);
        $data = [
          "status" => '0000',
        ];
        $datas = $data;
      }
    }
    return response()->json($datas);
  }


  public function AdjustBet()
  {
    // call betInformation
    $token = $this->betInformation();
    foreach ($token->data->txns as $tokenRaw) {
      $member =  MembersModel::where('id', $tokenRaw->userId)->first();
      $creditMember = $member->credit;
      $amountbet = $tokenRaw->betAmount;
      $bets = BetModel::query()->where('bet_id', $tokenRaw->platformTxId)
        ->where('platform', $tokenRaw->platform)
        ->first();

      if ($bets == null) {
        return [
          "status" => '0000',
        ];
      } else {
        $bets->update([

          'bet' => $amountbet,

          'updated_at' => Carbon::now(),
          // 'updated_at' => $tokenRaw->updateTime,
        ]);
      }
    }
    return [
      "status" => '0000',
      "balance" => $creditMember,
      "balanceTs"   => now()
    ];
  }

  public function UnVoidBet()
  {
    $token = $this->betInformation();
    foreach ($token->data->txns as $tokenRaw) {

      $amountbet = $tokenRaw->betAmount;
      $member =  MembersModel::where('id', $tokenRaw->userId)->first();
      $creditMember = $member->credit - $amountbet;

      $bets = BetModel::query()->where('bet_id', $tokenRaw->platformTxId)
        ->where('platform', $tokenRaw->platform)
        ->first();
      if ($bets == null) {
        return [
          "status" => '0000',
        ];
      } else {
        $bets->update([
          'credit' => $creditMember,
          'type' => 'Bet',
          'updated_at' => Carbon::now(),
          // 'updated_at' => $tokenRaw->updateTime,
        ]);

        $member->update([
          'credit' => $creditMember
        ]);

      }
    }
    return [
      "status" => '0000',
    ];
  }

  public function RefunBet()
  {
    // call betInformation
    $token = $this->betInformation();
    foreach ($token->data->txns as $tokenRaw) {
      $bets = BetModel::where('bet_id', $tokenRaw->platformTxId)
        ->where('platform', $tokenRaw->platform)
        ->first();

      $member =  MembersModel::where('id', $tokenRaw->userId)->first();

      if ($bets == null) {
        return [
          "status" => '0000',
          "balance" => $member->credit,
          "balanceTs"   => now()
        ];
      } else {

        $amountWin = $tokenRaw->winAmount;
        $amountBet = $tokenRaw->betAmount;
        $creditMember = $member->credit;

        // calculate balance member
        $amount = $creditMember + $amountBet - $amountWin;

        // update credit to table member
        $member->update([
          'credit' => $amount,
        ]);

        $bets->update([
          'credit' => $amount,
          'type' => 'Refund',
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
          // 'created_at' => $tokenRaw->betTime,
          // 'updated_at' => $tokenRaw->updateTime,
          'deskripsi' => 'Game Refund',
        ]);
      }
    }
    return [
      "status" => '0000',
      "balance" => $amount,
      "balanceTs"   => now()
    ];
  }

  public function Settle()
  {
    // call betInformation
    $token = $this->betInformation();
    foreach ($token->data->txns as $tokenRaw) {

      $bets = BetModel::where('bet_id', $tokenRaw->platformTxId)
        ->where('platform', $tokenRaw->platform)
        ->where('type', 'Bet')
        ->first();

      $member =  MembersModel::where('id', $tokenRaw->userId)->first();

      if ($bets == null) {
        return [
          "status" => '0000',
          "balance" => $member->credit,
          "balanceTs"   => now()->format("Y-m-d\TH:i:s.vP")
        ];
      } else {
        $amountWin = $tokenRaw->winAmount;
        $creditMember = $member->credit;
        $amount = $creditMember + $amountWin;

        // update credit to table member
        $member->update([
          'credit' => $amount,
          'updated_at' => Carbon::now(),
          // 'updated_at' => $tokenRaw->betTime,
        ]);

        // check win / lose (settle)
        if ($tokenRaw->winAmount <= 0) {
          $bets->update([
            'type' => 'Settle',
            'deskripsi' => 'Game Lose' . ' : ' . $tokenRaw->betAmount,
            'updated_by' => $member->id,
            'updated_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            // 'updated_at' => $tokenRaw->updateTime,
            // 'created_at' => $tokenRaw->betTime,
            'credit' => $amount
          ]);
        } else {
          $bets->update([
            'type' => 'Settle',
            'win' => $amountWin,
            'deskripsi' => 'Game win' . ' : ' . $amountWin,
            'updated_by' => $member->id,
            'updated_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            // 'updated_at' => $tokenRaw->updateTime,
            // 'created_at' => $tokenRaw->betTime,
            'credit' => $amount
          ]);
        }
      }
    }

    return [
      "status" => '0000',
      "balance" => $amount,
      "balanceTs"   => now()->format("Y-m-d\TH:i:s.vP")
    ];
  }

  public function UnSettle()
  {
    $token = $this->betInformation();
    foreach ($token->data->txns as $tokenRaw) {


      $amountbet = $tokenRaw->betAmount;
      $member =  MembersModel::where('id', $tokenRaw->userId)->first();

      $bets = BetModel::query()
        ->where('platform', $tokenRaw->platform)
        ->where('bet_id', $tokenRaw->platformTxId)->first();


      if ($bets == null) {
        return [
          "status" => '1025',
        ];
      } else {
        $member->update([
          'credit' => $member->credit - $bets->win
        ]);
        $bets->update([
          'type' => 'Bet',
          'bet' => $amountbet * $tokenRaw->gameInfo->odds,
          'updated_at' => Carbon::now(),
          // 'updated_at' => $tokenRaw->updateTime,
          'credit' => $member->credit - $bets->win,
        ]);

        return [
          "status" => '0000',
        ];
      }
    }
  }

  public function VoidSettle()
  {
    // call betInformation
    $token = $this->betInformation();
    foreach ($token->data->txns as $tokenRaw) {

      $amountbet = $tokenRaw->betAmount;
      $member =  MembersModel::where('id', $tokenRaw->userId)->first();
      $memeberCredit = $member->credit;

      $bets = BetModel::query()->where('bet_id', $tokenRaw->platformTxId)
        ->where('platform', $tokenRaw->platform)
        ->where('type', 'Settle')
        ->first();

      if ($bets == null) {
        return [
          "status" => '0000',
        ];
      } else {
        $bets->update([
          'amount' => $memeberCredit - $bets->win + $amountbet,
          'type' => 'Void',
          'bet' => $amountbet,
          'updated_at' => Carbon::now(),
          // 'updated_at' => $tokenRaw->updateTime,
        ]);
        $creditAfterVoid = $memeberCredit - $bets->win + $amountbet;
        $member->update([
          'credit' => $creditAfterVoid
        ]);
      }
    }
    return [
      "status" => '0000',
    ];
  }

  public function UnVoidSettle()
  {
    // call betInformation
    $token = $this->betInformation();
    foreach ($token->data->txns as $tokenRaw) {
      $amountbet = $tokenRaw->betAmount;
      $member =  MembersModel::where('id', $tokenRaw->userId)->first();
      $memeberCredit = $member->credit;

      $bets = BetModel::query()->where('bet_id', $tokenRaw->platformTxId)
        ->where('platform', $tokenRaw->platform)
        ->first();
      if ($bets == null) {
        return [
          "status" => '0000',
        ];
      } else {
        $bets->update([
          'credit' => $memeberCredit + $bets->win - $amountbet,
          'type' => 'Settle',
          'updated_at' => Carbon::now(),
          // 'updated_at' => $tokenRaw->updateTime,
        ]);
        $creditAfterVoid = $memeberCredit + $bets->win - $amountbet;
        $member->update([
          'credit' => $creditAfterVoid
        ]);
      }
    }

    return [
      "status" => '0000',
    ];
  }

  public function Give()
  {
    // @todo Need Changes or Waiting For UAT
    $token = $this->betInformation();
    foreach ($token->data->txns as $tokenRaw) {
      $member =  MembersModel::where('id', $tokenRaw->userId)->first();
      $betsGive = BetModel::where('bet_id', '=', $tokenRaw->promotionTxId)
      ->where('type', 'Give')->first();

      if ($betsGive) {
        return [
          "status" => '0000',
        ];
      } else {
        $bonusAmount = $tokenRaw->amount;
        $creditMember = $member->credit;
        $amount = $creditMember + $bonusAmount;
        $member->update([
          'credit' => $amount,
          'updated_at' => now()->format("Y-m-d\TH:i:s.vP"),
        ]);
        $bets = BetModel::create([
          'platform'  => $tokenRaw->platform,
          'created_by' => $tokenRaw->userId,
          'bet_id' => $tokenRaw->promotionTxId,
          'game_info' => 'live_casino',
          'type' => 'Give',
          'credit' => $amount,
          'bonus_daily_referal' => $bonusAmount,
          'created_at' => Carbon::now(),
          'constant_provider_id' => 11,
          'deskripsi' => 'Give' . ' : ' . $bonusAmount,
        ]);

        $nameProvider = BetModel::leftJoin('constant_provider', 'constant_provider.id', '=', 'bets.constant_provider_id')
              ->leftJoin('members', 'members.id', '=', 'bets.created_by')
              ->where('bets.id', $bets->id)->first();

        UserLogModel::logMemberActivity(
          'Member Bonus',
          $member,
          $bets,
          [
            'target' => $member->username,
            'activity' => 'Credit Bonus',
            'device' => $member->device,
            'ip' => $member->last_login_ip,
          ],
          "$member->username Received Bonus On $tokenRaw->platform . ' idr '. $bonusAmount"
        );
      }
    }
    return [
      "status" => '0000',
    ];
  }

  public function Tip()
  {
    // call betInformation
    $token = $this->betInformation();
    foreach ($token->data->txns as $tokenRaw) {
      $tipAmount = $tokenRaw->tip;
      $member =  MembersModel::where('id', $tokenRaw->userId)->first();
      $creditMember = $member->credit;
      $amount = $creditMember - $tipAmount;
      if ($creditMember < $tipAmount) {
        return response()->json([
          "status" => '1018',
          "desc"  => 'Not enough balance',
          "balance" => $creditMember,
          "balanceTs"   => now()->format("Y-m-d\TH:i:s.vP")
        ]);
      } else {
        $tipAfterCancel = BetModel::where('bet_id', '=', $tokenRaw->platformTxId)
                        ->where('type', 'Cancel_tip')->first();
        if ($tipAfterCancel) {
          return response()->json([
            "status" => '0000',
            "desc"  => 'Success',
            "balance" => $creditMember,
            "balanceTs"   =>  Carbon::now()->format("Y-m-d\TH:i:s.vP")
          ]);
        } else {
          // update credit to table member
          $member->update([
            'credit' => $amount,
            'updated_at' => now()->format("Y-m-d\TH:i:s.vP"),
          ]);
          $bets = BetModel::create([
            'platform'  => $tokenRaw->platform,
            'created_by' => $tokenRaw->userId,
            'bet_id' => $tokenRaw->platformTxId,
            'game_info' => 'live_casino',
            'game_id' => $tokenRaw->gameCode,
            'type' => 'Tip',
            'game' => $tokenRaw->gameName,
            'bet' => $tipAmount,
            'credit' => $amount,
            'created_at' => Carbon::now(),
            'constant_provider_id' => 11,
            'deskripsi' => 'Game Tip' . ' : ' . $tipAmount,
          ]);

          $nameProvider = BetModel::leftJoin('constant_provider', 'constant_provider.id', '=', 'bets.constant_provider_id')
            ->leftJoin('members', 'members.id', '=', 'bets.created_by')
            ->where('bets.id', $bets->id)->first();
          $member =  MembersModel::where('id', $bets->created_by)->first();

          UserLogModel::logMemberActivity(
            'create bet',
            $member,
            $bets,
            [
              'target' => $nameProvider->username,
              'activity' => 'Tip',
              'device' => $nameProvider->device,
              'ip' => $nameProvider->last_login_ip,
            ],
            "$nameProvider->username . ' Bet on ' . $nameProvider->constant_provider_name . ' type ' .  $bets->game_info . ' idr '. $nameProvider->bet"
          );
        }
      }
    }
    $member =  MembersModel::where('id', $tokenRaw->userId)->first();
    return [
      "status" => '0000',
      "desc"  => 'Success',
      "balance" => $member->credit,
      "balanceTs" => now()->format("Y-m-d\TH:i:s.vP")
    ];
  }

  public function CancelTip()
  {
    {
      // call betInformation
      $token = $this->betInformation();
      $datas;
      foreach ($token->data->txns as $tokenRaw) {
        $member =  MembersModel::where('id', $tokenRaw->userId)->first();
        $creditMember = $member->credit;
        $cancelTip = BetModel::where('bet_id', '=', $tokenRaw->platformTxId)
              ->where('platform', $tokenRaw->platform)->where('type', 'Cancel_tip')->first();

        if ($cancelTip) {
          $data = [
            "status" => '0000',
            "desc"  => 'Success',
            "balance" => $creditMember,
            "balanceTs"   => Carbon::now()->format("Y-m-d\TH:i:s.vP")
          ];

          $datas = $data;
        }else{
          $tipBeforeCancel = BetModel::where('bet_id', '=', $tokenRaw->platformTxId)
                        ->where('platform', $tokenRaw->platform)->where('type', 'Tip')->first();
          if ($tipBeforeCancel) {
            //update type Cancel_tip
            BetModel::query()->where('bet_id', '=', $tokenRaw->platformTxId)
              ->where('platform', $tokenRaw->platform)
              ->update([
                'type' => 'Cancel_tip'
              ]);
            //update balance member
            $tipAfterCancel = BetModel::where('bet_id', '=', $tokenRaw->platformTxId)
                          ->where('platform', $tokenRaw->platform)->where('type', 'Cancel_tip')->first();

            MembersModel::where('id', $tokenRaw->userId)->update([
                'credit' => $creditMember + $tipAfterCancel->bet
            ]);
            $balanceUpdate =  MembersModel::where('id', $tokenRaw->userId)->first();
            $tipAfterCancel->update([
              'credit' => $balanceUpdate->credit
            ]);
            $data = [
              "status" => '0000',
              "desc"  => 'Success',
              "balance" => $balanceUpdate->credit,
              "balanceTs"   => Carbon::now()->format("Y-m-d\TH:i:s.vP")
            ];
            $datas = $data;
          } else {

            BetModel::create([
              'platform'  => $tokenRaw->platform,
              'created_by' => $tokenRaw->userId,
              'bet_id' => $tokenRaw->platformTxId,
              'game_info' => 'live_casino',
              'game_id' => $tokenRaw->gameCode,
              'type' => 'Cancel_tip',
              'game' => $tokenRaw->gameName,
              'bet' => 0,
              'created_at' => Carbon::now(),
              'constant_provider_id' => 11,
              'deskripsi' => 'Cancel tip before place bet',
            ]);
            $data = [
              "status" => '0000',
              "desc"  => 'Success',
              "balance" => $creditMember,
              "balanceTs"   => Carbon::now()->format("Y-m-d\TH:i:s.vP")
            ];
            $datas = $data;
          }
        }
      }
      // For $creditMember will be Call on last index of loop and return again
      return response()->json($datas);
    }
  }

  // slot and fish
  public function BetNSettle()
  {
    try {      
      // call betInformation
      $token = $this->betInformation();
      foreach ($token->data->txns as $tokenRaw) {
        $member =  MembersModel::where('id', $tokenRaw->userId)->first();
        $amountbet = $tokenRaw->betAmount * 1000;
        $creditMember = $member->credit;
        $win = $tokenRaw->winAmount * 1000;
        $amount = $creditMember - $amountbet + $win;
        $this->betTime = $tokenRaw->betTime;

        if ($amount < 0) {
          return response()->json([
            "status" => '1018',
            "desc" => "Not Enough Balance"
          ]);
        } else {
          // check if bet already exist
          $bets = BetModel::where('bet_id', $tokenRaw->platformTxId)->first();

          // this will check when the have canceled we need do nothing or not deducted the balance
          if ($bets) {
            if ($bets->type === 'Cancel') {
              return [
                "status" => '0000',
                "balance" => (string)round($creditMember / $this->ratio, 3),
                "balanceTs"   => $this->betTime
              ];
            }
            return [
              "status" => '0000',
              "balance" => (string)round($creditMember / $this->ratio, 3),
              "balanceTs"   => $this->betTime
            ];
          } else {
            // update credit to table member
            $member->update([
              'credit' => $amount,
              'created_at' => Carbon::now(),
              'updated_at' => Carbon::now(),
              // 'created_at' => $tokenRaw->betTime,
              // 'updated_at' => $tokenRaw->updateTime,
            ]);

            $bets = BetModel::create([
              'platform'  => $tokenRaw->platform,
              'created_by' => $tokenRaw->userId,
              'updated_by' => $tokenRaw->userId,
              'bet_id' => $tokenRaw->platformTxId,
              'game_info' => $tokenRaw->gameType == 'SLOT' ? 'slot' : 'fish',
              'game_id' => $tokenRaw->gameCode,
              'round_id' => $tokenRaw->roundId,
              'credit' => $amount,
              'type' => 'Settle',
              'game' => $tokenRaw->gameName,
              'bet' => $amountbet,
              'win' => $tokenRaw->winAmount * 1000,
              'created_at' => Carbon::now(),
              // 'created_at' => $tokenRaw->betTime,
              'constant_provider_id' => $tokenRaw->gameType == 'SLOT' ? 7 : 15,
              'deskripsi' => $tokenRaw->winAmount == 0 ? 'Game Bet/Lose' . ' : ' . $tokenRaw->winAmount : 'Game Win' . ' : ' . $tokenRaw->winAmount,
            ]);

            $nameProvider = BetModel::leftJoin('constant_provider', 'constant_provider.id', '=', 'bets.constant_provider_id')
              ->leftJoin('members', 'members.id', '=', 'bets.created_by')
              ->where('bets.id', $bets->id)->first();
            $member =  MembersModel::where('id', $bets->created_by)->first();

            UserLogModel::logMemberActivity(
              'create bet',
              $member,
              $bets,
              [
                'target' => $nameProvider->username,
                'activity' => 'Bet',
                'device' => $nameProvider->device,
                'ip' => $nameProvider->last_login_ip,
              ],
              "$nameProvider->username . ' Bet on ' . $nameProvider->constant_provider_name . ' type ' .  $bets->game_info . ' idr '. $nameProvider->bet"
            );

            BetModel::where('game_id', $tokenRaw->gameCode)->first();
          }
        }
      }
      
      $now = Carbon::now()->setTimezone('Asia/Jakarta');
      return [
        "status" => '0000',
        "balance" => (string)round($amount / $this->ratio, 3),
        "balanceTs"   => $now->format("Y-m-d\TH:i:s.vP")
      ];
    } catch (\Throwable $th) {
      return response()->json([
          "code" => 500,
          "message" => "Internal Serve Error"
      ]);
    }
  }
  public function CancelBetNSettle()
  {
    // call betInformation
    $token = $this->betInformation();
    foreach ($token->data->txns as $tokenRaw) {
      $member =  MembersModel::where('id', $tokenRaw->userId)->first();
      $bet    = BetModel::query();
      $bets   = $bet->where('bet_id', '=', $tokenRaw->platformTxId)
        ->where('platform', $tokenRaw->platform)->orderBy('created_at', 'desc')->first();

      if (is_null($bets)) {
        return [
          "status" => '0000',
          "balance" => $member->credit / $this->ratio,
          "balanceTs"   => Carbon::now()->format("Y-m-d\TH:i:s.vP")
        ];
      }

      // Prevent if bet already deducted
      if ($bets->type === 'Cancel') {
        return [
          "status" => '0000',
          "balance" => $member->credit / $this->ratio,
          "balanceTs"   => Carbon::now()->format("Y-m-d\TH:i:s.vP")
        ];
      }

      if ($bets->win == 0) {
        $amountbet = $tokenRaw->betAmount;
        $creditMember = $member->credit;
        $amount = $creditMember + ($amountbet * $this->ratio);
      } else {
        $amountbet = $tokenRaw->betAmount - ($bets->win / $this->ratio);
        $creditMember = $member->credit;
        $amount = $creditMember + ($amountbet * $this->ratio);
      }

      BetModel::create([
        'platform'  => $tokenRaw->platform,
        'created_by' => $tokenRaw->userId,
        'updated_by' => $tokenRaw->userId,
        'bet_id' => $tokenRaw->platformTxId,
        'game_info' => $tokenRaw->gameType == 'SLOT' ? 'slot' : 'fish',
        'game_id' => $tokenRaw->gameCode,
        'round_id' => $tokenRaw->roundId,
        'type' => 'Cancel',
        'game' => $tokenRaw->gameName,
        'bet' => $tokenRaw->betAmount * $this->ratio,
        'credit' => $amount,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
        'constant_provider_id' => $tokenRaw->gameType == 'SLOT' ? 7 : 15,
      ]);      

      $member->update([
        'credit' => $amount,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
        // 'created_at' => $tokenRaw->updateTime,
        // 'updated_at' => $tokenRaw->updateTime,
      ]);
    }
    return [
      "status" => '0000',
      "balance" => $member->credit / $this->ratio,
      "balanceTs"   => Carbon::now()->format("Y-m-d\TH:i:s.vP")
    ];
  }
  public function FreeSpin()
  {
    // call betInformation
    $token = $this->betInformation();
    foreach ($token->data->txns as $tokenRaw) {
      $bets = BetModel::where('bet_id', $tokenRaw->platformTxId)
        ->where('platform', $tokenRaw->platform)
        ->first();
      if ($bets == null) {
        return [
          "status" => '9999',
          "desc" => 'bet is not exists'
        ];
      } else {

        $member =  MembersModel::where('id', $tokenRaw->userId)->first();
        $creditMember = $member->credit;
        $freeSpin = $tokenRaw->winAmount * 1000;
        $amount = $creditMember;

        // update credit to table member
        $member->update([
          'credit' => $amount,
          'updated_at' => Carbon::now(),
          // 'updated_at' => $tokenRaw->updateTime,
        ]);

        // get free spin
        $bets->update([
          'credit' => $amount,
          'win' => $freeSpin,
          'updated_at' => Carbon::now(),
          // 'updated_at' => $tokenRaw->updateTime,
          'deskripsi' => 'Free Spin' . ' : ' . $freeSpin,
        ]);
      }
    }
    return [
      "status" => '0000',
      "balance" => $member->credit / $this->ratio,
      "balanceTs"   => now()->format("Y-m-d\TH:i:s.vP")
    ];
  }
}
