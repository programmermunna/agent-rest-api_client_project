<?php

use App\Http\Controllers\Api\v1\MemberController;
use App\Http\Controllers\Api\v2\BetsTogelController;
use App\Http\Controllers\Api\v2\OutResult;
use App\Http\Controllers\ProviderService\GameHallController;
use App\Http\Controllers\ProviderService\IONXController;
use App\Http\Controllers\ProviderService\ProviderController;
use App\Http\Controllers\ProviderService\QueenmakerController;
use App\Http\Controllers\TogelDreamsBookController;
use App\Http\Controllers\TogelPeraturanGame;
use App\Http\Controllers\TogelSettingGameController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::group(['namespace' => 'v1', 'as' => 'v1.', 'prefix' => 'v1'], function () {
    Route::post('/member/login', 'JWTAuthController@authenticate');
    Route::post('/member/register', 'JWTAuthController@register')->name('registerJwt');

    // probation login and register
    // Route::post('/login', 'JWTAuthController@probationLogin');
    // Route::post('/register', 'JWTAuthController@probationRegister');

    Route::group(['middleware' => ['jwt.verify'], 'prefix' => 'member'], function () {
        Route::get('/history_by_type', 'MemberController@historyAll');
        // Member
        Route::get('/', 'JWTAuthController@getAuthenticatedMember');
        Route::get('/balance', 'JWTAuthController@getBalanceMember');
        Route::get('/last-bet-win', 'JWTAuthController@lastBetWin');
        Route::get('/last_bet', 'JWTAuthController@lastBet'); # Not Used from Nov, 18 2022 to now
        Route::get('/last_win', 'JWTAuthController@lastWin'); # Not Used from Nov, 18 2022 to now
        Route::get('/history', 'JWTAuthController@history'); # Not Used from Nov, 18 2022 to now
        Route::post('/refresh', 'JWTAuthController@refresh');
        Route::post('/logout', 'JWTAuthController@logout');
        // Route::get('/bank_account', 'MemberController@bank_account'); # Not Used from Nov, 18 2022 to now
        Route::post('/change-password', 'JWTAuthController@changePassword');
        Route::get('/bonus-referal', 'MemberController@bonusReferal');

        // Probation
        // Route::post('/updateAccount', 'JWTAuthController@probationUpdateAccount');
        // Route::post('/deleteAccount', 'JWTAuthController@probationDeleteAccount');
        // Route::get('/accountList', 'JWTAuthController@probationAccountList');

        // Deposit
        Route::post('/deposit/create', 'DepositController@create');

        // Bonus
        Route::group(['prefix' => 'bonus'], function () {
            # Bonus Freebet
            Route::get('/setting-bonus-freebet', 'DepositController@settingBonusFreebet');
            Route::get('/freebet-list', 'DepositController@freebetBonus');
            Route::post('/bonus-freebet-giveup', 'DepositController@BonusFreebetGivUp');

            # Bonus Freebet
            Route::get('/setting-bonus-deposit', 'DepositController@settingBonusDeposit');
            Route::get('/deposit-list', 'DepositController@depositBonus');
            Route::post('/bonus-deposit-giveup', 'DepositController@BonusDepositGivUp');
        });

        //Withdraw
        Route::post('/withdraw/create', 'WithdrawController@create');
        Route::get('/win_lose_status', 'MemberController@winLoseStatus');
        Route::get('/deposit_withdraw_status', 'MemberController@depostiWithdrawStatus');

        //Memo
        Route::group(['prefix' => 'memo'], function () {
            Route::post('/create', 'MemoController@create');
            Route::get('/inbox', 'MemoController@inbox');
            Route::get('/sent', 'MemoController@sent');
            Route::post('/read', 'MemoController@read');
            Route::post('/reply', 'MemoController@reply');
            Route::get('/detail/{id}', 'MemoController@detail');
            Route::get('/notify-memo', 'MemoController@NotifyMemo');
        });

        // statement slot-fish
        Route::get('/statement', 'MemberController@getStatement');
        Route::get('/bonus', 'MemberController@bonusTurnover');
        //statement depo-wd
        Route::get('/statement-depo-wd', 'MemberController@statementWdDepo');

        // create rekening member
        Route::post('/create_rekening_member', 'MemberController@createRekeningMember');
        //list rekening member
        Route::get('/list_rekening_member', 'MemberController@listRekMember');

        //New list rekening agent
        Route::get('/list_rek_agent', 'MemberController@listRekAgent');
        //rekening member is_depo
        Route::get('/rekening_member_wd', 'MemberController@rekMemberWd');
        // update rekening member
        Route::post('/update_rekening_member', 'MemberController@updateRekeningMemberWd');

        //Referral
        Route::group(['prefix' => 'referral'], function () {
            Route::get('/code', 'ReferralController@code');
            Route::get('/list', 'ReferralController@list');
        });

    });
    // cashback
    Route::get('/cashback', 'MemberController@cashbackSlot');

    // daily referal
    Route::post('/daily-referal', 'MemberController@dailyReferal');

    //Get destination banks
    Route::group(['middleware' => ['jwt.verify']], function () {
        Route::get('/bank/destination', 'BankController@destination');
    });

    //open api with secret
    Route::group(['middleware' => ['open.api']], function () {
        Route::group(['prefix' => 'etc'], function () {
            // Route::get('/broadcast', 'LanlanController@broadcast'); # Not Used from Nov, 18 2022 to now
            Route::get('/broadcast', 'LanlanController@broadcast');
            Route::get('/apk', 'LanlanController@apk');
            Route::get('/livechat', 'LanlanController@livechat');
            Route::get('/whatsapp', 'LanlanController@whatsapp');
            Route::get('/multimedia', 'LanlanController@multimedia');
        });

        Route::group(['prefix' => 'bank'], function () {
            Route::get('/', 'BankController@bank');
            Route::get('/bank_wd', 'BankController@bankWithdraw');
            Route::get('/availability', 'BankController@availability');
        });

        Route::group(['prefix' => 'cms'], function () {
            Route::get('/website-content/{slug}', 'CmsController@websiteContent'); //{slug} => api general-info , my-account , about, help , rules , contact-us
            Route::get('/image-contents/{type}', 'CmsController@imageContent'); //{type}=> api all , popup , mobile , slide , promotion ///
            Route::get('/game-content/{slug}', 'CmsController@gameContent');
            Route::get('/banner_promo_bonus', 'CmsController@bannerPromoBonus');
        });

        Route::group(['prefix' => 'contact'], function () {
            Route::post('/message/create', 'ContactUsController@create');
        });

        //maintenance
        Route::group(['prefix' => 'maintenance'], function () {
            Route::get('/', 'LanlanController@maintenance');
            Route::post('/force-logout', 'JWTAuthController@forceLogout');
        });

        // maintenance-website staging
        Route::group(['prefix' => 'maintenance-website'], function () {
            Route::post('/', 'LanlanController@maintenanceWebsite');
        });

        Route::group(['prefix' => 'setting'], function () {
            Route::get('/rolling-value', 'SettingController@rollingValue');
            Route::get('/limit', 'SettingController@limit');
            Route::get('/referral_game/{type}', 'SettingController@referral_game');
            Route::get('/list_togel', 'SettingController@list_togel');
            Route::get('/web_page', 'SettingController@web_page');
            Route::get('/footer_tag', 'SettingController@footer_tag');
            Route::get('/whatsapp_url', 'SettingController@whatsappUrl');
            Route::get('/social', 'SettingController@social');
            Route::get('/seo', 'SettingController@seo');

        });
    });
});
// api for integration
Route::group(['prefix' => 'endpoint'], function () {
    Route::post('bet', [ProviderController::class, 'bet']); # Not Used from Ock, 25 2022 to now
    Route::post('betSpade', [ProviderController::class, 'betSpade']); # Not Used from Ock, 25 2022 to now
    Route::post('get_history_pragmatic', [ProviderController::class, 'gameHistoryPragmatic']); # Not Used from Ock, 25 2022 to now
    Route::post('round', [ProviderController::class, 'getGameRound']); # Not Used from Ock, 25 2022 to now
    Route::post('bet_pragmatic', [ProviderController::class, 'betPragmatic']); # Not Used from Ock, 25 2022 to now
    Route::post('result_pragmatic', [ProviderController::class, 'resultPragmatic']); # Not Used from Ock, 25 2022 to now
    Route::post('cancel_bet_pragmatic', [ProviderController::class, 'cancelBetPragmatic']); # Not Used from Ock, 25 2022 to now

    Route::post('result_habanero', [ProviderController::class, 'resultHabanero']); # Not Used from Ock, 25 2022 to now

    # Joker Gaming Slot
    Route::post('bet_joker', [ProviderController::class, 'betJoker']); # Not Used from Ock, 25 2022 to now
    Route::post('settle_bet_joker', [ProviderController::class, 'settleBetJoker']); # Not Used from Ock, 25 2022 to now
    Route::post('cancel_bet_joker', [ProviderController::class, 'cancelBetJoker']); # Not Used from Ock, 25 2022 to now

    Route::post('balance', [ProviderController::class, 'balance']); # Not Used from Ock, 25 2022 to now
    Route::post('result', [ProviderController::class, 'result']); # Not Used from Ock, 25 2022 to now
    Route::post('transaction_joker', [ProviderController::class, 'transaction']); # Not Used from Ock, 25 2022 to now
    Route::post('withdraw_joker', [ProviderController::class, 'withdraw']); # Not Used from Ock, 25 2022 to now
    Route::post('deposit_joker', [ProviderController::class, 'deposit']); # Not Used from Ock, 25 2022 to now
    Route::post('resultSpade', [ProviderController::class, 'resultSpade']); # Not Used from Ock, 25 2022 to now

    # Playtech
    Route::post('bet_playtech', [ProviderController::class, 'betPlaytech']); # Not Used from Ock, 25 2022 to now
    Route::post('cancel_bet_playtech', [ProviderController::class, 'cancelBetPlaytech']); # Not Used from Ock, 25 2022 to now
    Route::post('result_playtech', [ProviderController::class, 'resultPlaytech']); # Not Used from Ock, 25 2022 to now

    Route::post('get_history_spade_gaming', [ProviderController::class, 'getBetHistorySpadeGaming']); # Not Used from Ock, 25 2022 to now

    /**
     * @deprecated
     */
    /* Route::post('transfer-in-out', [ProviderController::class, 'resultPgSoft']); */
    Route::post('transfer-in-out', [ProviderController::class, 'PgSoftTransaction']); # Not Used from Ock, 25 2022 to now
    # Game Gall
    Route::post("bet_gameHall", [GameHallController::class, "listenTransaction"]); # Not Used from Ock, 25 2022 to now
    Route::post("result_gameHall", [GameHallController::class, "resultGameHall"]); # Not Used from Ock, 25 2022 to now

    #Queenmaker api route
    Route::post("debit", [QueenmakerController::class, "getDebitQueenMaker"]); # Not Used from Ock, 25 2022 to now
    Route::post("credit", [QueenmakerController::class, "getCreditQueenMaker"]); # Not Used from Ock, 25 2022 to now

    Route::post('detail_spade_gaming', [ProviderController::class, 'detailSpadeGaming']); # Not Used from Ock, 25 2022 to now

    # Togel
    Route::get("settingGames", [TogelSettingGameController::class, 'getTogelSettingGame']);
    // Route::match(['get', 'post'], "sisaQuota", [TogelSettingGameController::class, 'sisaQuota']);
    Route::get('provider', [OutResult::class, 'getResultByProvider']);
    Route::get('paitoEight', [OutResult::class, 'paitoEight']);
    Route::match(['get', 'post'], "paitoAll", [OutResult::class, 'paitoAll']);
    // Route::match(['get', 'post'], "paitoTest", [OutResult::class, 'paitoTestAll']);
    Route::get('shio', [OutResult::class, 'getShioTables']);
    Route::get('list_out_result', [OutResult::class, 'getAllResult']);
    Route::get('pasaran', [OutResult::class, 'getPasaran']);
    Route::get('allPasaran', [OutResult::class, 'getAllPasaran']);
    Route::get('dreamBooks', [TogelDreamsBookController::class, 'getDreamsBook']);
    Route::get('globalSetting', [TogelSettingGameController::class, 'getGlobalSettingGame']);
    Route::get('rules', [TogelPeraturanGame::class, 'getPeraturanGame']);
    Route::get('getDetailTransaksi', [OutResult::class, 'getDetailTransaksi']);
    Route::get('getDetailTransaksiTogel/{id}', [MemberController::class, 'detailDataTogel']);
    # Togel Must Secure when bettin
    Route::middleware(['jwt.verify'])->group(function () {
        Route::post('storeTogel', [BetsTogelController::class, 'store']);
    });
});

Route::group(['prefix' => 'ionx'], function () {
    Route::post("deduct-player-balance", [IONXController::class, "deductPlayerBalance"]); # Not Used from Ock, 25 2022 to now
    Route::post("get-player-balance", [IONXController::class, "getPlayerBalance"]); # Not Used from Ock, 25 2022 to now
    Route::post("rollback-player-balance", [IONXController::class, "rollbackPlayerBalance"]); # Not Used from Ock, 25 2022 to now
    Route::post("Insert-running-bet", [IONXController::class, "InsertRunningBet"]); # Not Used from Ock, 25 2022 to now
    Route::post("settle-bet", [IONXController::class, "SettleBet"]); # Not Used from Ock, 25 2022 to now
    Route::post("insert-game-announcement", [IONXController::class, "insertGameAnnouncement"]); # Not Used from Ock, 25 2022 to now
});
