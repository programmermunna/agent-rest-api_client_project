<?php

namespace App\Http\Controllers\ProviderService;

use App\Http\Controllers\Controller;
use App\Models\BonusModel;
use App\Models\ConstantProvider;
use App\Models\UploadBonusModel;
use Firebase\JWT\JWT;
use App\Models\MembersModel;
use App\Models\BetModel;
use App\Models\UserLogModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

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
//      case 'adjustBet':
//        return $this->AdjustBet();
//        break;

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
        $betAfterCancel = BetModel::where('bet_id', '=', $tokenRaw->platformTxId)
                        ->where('platform', $tokenRaw->platform)->where('type', 'Cancel')->first();

        if ($betAfterCancel) {
          return [
            "status" => '0000',
            "balance" => intval($creditMember),
            "balanceTs"   => now()->format("Y-m-d\TH:i:s.vP")
          ];
        } else {
          // update credit to table member
          $member->update([
            'credit' => $amount,
            'updated_at' => $tokenRaw->betTime,
          ]);

          $bets = BetModel::create([
            'platform'  => $tokenRaw->platform,
            'created_by' => $tokenRaw->userId,
            'updated_by' => $tokenRaw->userId,
            'bet_id' => $tokenRaw->platformTxId,
            'game_info' => 'live_casino',
            'game_id' => $tokenRaw->gameCode,
            'round_id' => $tokenRaw->roundId,
            'type' => 'Bet',
            'game' => $tokenRaw->gameName,
            'bet' => $amountbet,
            'credit' => $amount,
            'created_at' => $tokenRaw->betTime,
            'constant_provider_id' => 7,
            'deskripsi' => 'Game Bet/Lose' . ' : ' . $amountbet,
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
    return [
      "status" => '0000',
      "balance" => intval($amount),
      "balanceTs"   => now()->format("Y-m-d\TH:i:s.vP")
    ];
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
          $bets = BetModel::create([
            'platform'  => $tokenRaw->platform,
            'created_by' => $tokenRaw->userId,
            'bet_id' => $tokenRaw->platformTxId,
            'game_info' => 'live_casino',
            'game_id' => $tokenRaw->gameCode,
            'round_id' => $tokenRaw->roundId,
            'type' => 'Cancel',
            'bet' => 0,
            'created_at' => Carbon::now()->format("Y-m-d\TH:i:s.vP"),
            'constant_provider_id' => 7,
            'deskripsi' => 'Cancel bet befor place bet' ,
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
    return response()->json($datas);
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

      $bets = BetModel::query()->where('bet_id', $tokenRaw->platformTxId)
        ->where('platform', $tokenRaw->platform)
        ->where('type', 'Void')
        ->first();

      if ($bets == null) {
        $data = [
          "status" => '0000',
        ];
        $datas = $data;
      } else {
        $bets->update([
          'type' => 'Void',
          'bet' => $amountbet,
          'credit' => $creditMember,
          'updated_at' => $tokenRaw->updateTime,
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

          'updated_at' => $tokenRaw->updateTime,
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
          'type' => 'Bet',
          'updated_at' => $tokenRaw->updateTime,
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
          'type' => 'Refund',
          'created_at' => $tokenRaw->betTime,
          'updated_at' => $tokenRaw->updateTime,
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
          'updated_at' => $tokenRaw->betTime,
        ]);

        // check win / lose (settle)
        if ($tokenRaw->winAmount <= 0) {
          $bets->update([
            'type' => 'Settle',
            'deskripsi' => 'Game Bet/Lose' . ' : ' . $tokenRaw->betAmount,
            'updated_at' => $tokenRaw->updateTime,
            'created_at' => $tokenRaw->betTime,
            'credit' => $amount
          ]);
        } else {
          $bets->update([
            'type' => 'Settle',
            'win' => $amountWin,
            'deskripsi' => 'Game win' . ' : ' . $amountWin,
            'updated_at' => $tokenRaw->updateTime,
            'created_at' => $tokenRaw->betTime,
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
          'updated_at' => $tokenRaw->updateTime,
          'credit' => $member->credit,
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
          'type' => 'Void',
          'bet' => $amountbet,
          'updated_at' => $tokenRaw->updateTime,
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
          'type' => 'Settle',
          'updated_at' => $tokenRaw->updateTime,
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
          'created_at' => now(),
          'constant_provider_id' => 7,
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
            'created_at' => now(),
            'constant_provider_id' => 7,
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
              'created_at' => now(),
              'constant_provider_id' => 7,
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
              "balance" => $creditMember / $this->ratio,
              "balanceTs"   => $this->betTime
            ];
          }
          return [
            "status" => '0000',
            "balance" => $creditMember / $this->ratio,
            "balanceTs"   => $this->betTime
          ];
        } else {
          // update credit to table member
          $member->update([
            'credit' => $amount,
            'created_at' => $tokenRaw->betTime,
            'updated_at' => $tokenRaw->updateTime,
          ]);

          $bets = BetModel::create([
            'platform'  => $tokenRaw->platform,
            'created_by' => $tokenRaw->userId,
            'updated_by' => $tokenRaw->userId,
            'bet_id' => $tokenRaw->platformTxId,
            'game_info' => $tokenRaw->gameType == 'SLOT' ? 'slot' : 'fish',
            'game_id' => $tokenRaw->gameCode,
            'round_id' => $tokenRaw->roundId,
            'type' => 'Settle',
            'game' => $tokenRaw->gameName,
            'bet' => $amountbet,
            'win' => $tokenRaw->winAmount * 1000,
            'created_at' => $tokenRaw->betTime,
            'constant_provider_id' => 7,
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
    return [
      "status" => '0000',
      "balance" => $amount / $this->ratio,
      "balanceTs"   => now()->format("Y-m-d\TH:i:s.vP")
    ];
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
        'created_at' => now(),
        'updated_at' => $tokenRaw->updateTime,
        'constant_provider_id' => 7,
      ]);

      if ($bets->win == 0) {
        $amountbet = $tokenRaw->betAmount;
        $creditMember = $member->credit;
        $amount = $creditMember + ($amountbet * $this->ratio);
      } else {
        $amountbet = $tokenRaw->betAmount - ($bets->win / $this->ratio);
        $creditMember = $member->credit;
        $amount = $creditMember + ($amountbet * $this->ratio);
      }

      $member->update([
        'credit' => $amount,
        'created_at' => $tokenRaw->updateTime,
        'updated_at' => $tokenRaw->updateTime,
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
          'updated_at' => $tokenRaw->updateTime,
        ]);

        // get free spin
        $bets->update([
          'win' => $freeSpin,
          'updated_at' => $tokenRaw->updateTime,
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
