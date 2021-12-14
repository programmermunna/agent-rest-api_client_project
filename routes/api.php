<?php

use App\Http\Controllers\Api\v2\BetsTogelController;
use App\Http\Controllers\Api\v2\OutResult;
use App\Http\Controllers\ProviderService\GameHallController;
use App\Http\Controllers\ProviderService\QueenmakerController;
use App\Http\Controllers\ProviderService\ProviderController;
use App\Http\Controllers\TogelDreamsBookController;
use App\Http\Controllers\TogelPeraturanGame;
use App\Http\Controllers\TogelSettingGameController;
use App\Models\TogelGame;
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

    Route::group(['middleware' => ['jwt.verify'], 'prefix' => 'member'], function () {
        Route::get('/history_by_type', 'MemberController@historyAll');
        // Member
        Route::get('/', 'JWTAuthController@getAuthenticatedMember');
        Route::get('/last_bet', 'JWTAuthController@lastBet');
        Route::get('/last_win', 'JWTAuthController@lastWin');
        Route::get('/history', 'JWTAuthController@history');
        Route::post('/refresh', 'JWTAuthController@refresh');
        Route::post('/logout', 'JWTAuthController@logout');
        Route::get('/bank_account', 'MemberController@bank_account');
        Route::post('/change-password', 'JWTAuthController@changePassword');

        // Deposit
        Route::post('/deposit/create', 'DepositController@create');

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


    //Get destination banks
    Route::group(['middleware' => ['jwt.verify']], function () {
        Route::get('/bank/destination', 'BankController@destination');
    });

    //open api with secret
    Route::group(['middleware' => ['open.api']], function () {
        Route::group(['prefix' => 'etc'], function () {
            // Route::get('/broadcast', 'LanlanController@broadcast');
            Route::get('/broadcast', 'LanlanController@broadcast');
            Route::get('/apk', 'LanlanController@apk');
            Route::get('/livechat', 'LanlanController@livechat');
            Route::get('/whatsapp', 'LanlanController@whatsapp');
            Route::get('/multimedia', 'LanlanController@multimedia');
        });

        Route::group(['prefix' => 'bank'], function () {
            Route::get('/', 'BankController@bank');
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
        });

        // maintenance-website staging
        Route::group(['prefix' => 'maintenance-website'], function () {
            Route::post('/', 'LanlanController@maintenanceWebsite');
        });

        Route::group(['prefix' => 'setting'], function () {
            Route::get('/limit', 'SettingController@limit');
            Route::get('/referral_game/{type}', 'SettingController@referral_game');
            Route::get('/web_page', 'SettingController@web_page');
            Route::get('/social', 'SettingController@social');
            Route::get('/seo', 'SettingController@seo');

        });
    });
});
    // api for integration
Route::group(['prefix' => 'endpoint'], function () {
    Route::post('bet',  [ProviderController::class, 'bet']);
    Route::post('cancel-bet',  [ProviderController::class, 'cancelBet']);
    Route::post('get_history_pragmatic',  [ProviderController::class, 'gameHistoryPragmatic']);
    Route::post('round',  [ProviderController::class, 'getGameRound']);
    Route::post('bet_pragmatic',  [ProviderController::class, 'betPragmatic']);
    Route::post('bet_joker',  [ProviderController::class, 'betJoker']);
    Route::post('result_pragmatic',  [ProviderController::class, 'resultPragmatic']);
    Route::post('balance', [ProviderController::class, 'balance']);
    Route::post('result', [ProviderController::class, 'result']);
    Route::post('result_playtech', [ProviderController::class, 'resultPlaytech']);
    Route::post('get_history_spade_gaming', [ProviderController::class, 'getBetHistorySpadeGaming']);
    # Game Gall 
    Route::post("bet_gameHall" , [GameHallController::class , "listenTransaction"]);
    Route::post("result_gameHall" , [GameHallController::class , "resultGameHall"]);
    
    #Queenmaker api route
    Route::post("debit" , [QueenmakerController::class , "getDebitQueenMaker"]);
    Route::post("credit" , [QueenmakerController::class , "getCreditQueenMaker"]);


	# Togel
    Route::post('detail_spade_gaming', [ProviderController::class, 'detailSpadeGaming']);
	Route::get("settingGames", [TogelSettingGameController::class, 'getTogelSettingGame']);
	Route::get('provider', [OutResult::class, 'getResultByProvider']);
	Route::get('shio' , [OutResult::class , 'getShioTables']);
	Route::get('list_out_result', [OutResult::class, 'getAllResult']);
	Route::get('pasaran', [OutResult::class, 'getPasaran']);
	Route::get('dreamBooks', [TogelDreamsBookController::class, 'getDreamsBook']);
	Route::get('globalSetting' , [TogelSettingGameController::class , 'getGlobalSettingGame']);
	Route::get('rules' , [TogelPeraturanGame::class , 'getPeraturanGame']);
	Route::get('getDetailTransaksi' , [OutResult::class , 'getDetailTransaksi']);
	# Togel Must Secure when betting
	Route::middleware(['jwt.verify'])->group(function () {
		Route::post('storeTogel', [BetsTogelController::class, 'store']);
	});
});
