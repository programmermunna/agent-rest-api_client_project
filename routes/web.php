<?php

use App\Events\BetTogelBalanceEvent;
use App\Events\NotifyNewMemo;
use App\Events\NotifyReplyMessageEvent;
use App\Events\WithdrawalCreateBalanceEvent;
use App\Models\MembersModel;
use App\Models\MemoModel;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

/*
 * Global Routes
 *
 * Routes that are used between both frontend and backend.
 */

Route::get('/', function () {
    return json_encode('success');
});

// WEB SOCKET START
# Test Event Balance
Route::get('event-balance-test', function (Request $request) {
    $user = MembersModel::select('id', 'credit', 'username')->find(request('id', 1));
    if (request('event') == 'betTogel') {
        BetTogelBalanceEvent::dispatch($user->toArray());
    }
    if (request('event') == 'createWithdraw') {
        WithdrawalCreateBalanceEvent::dispatch($user->toArray());
    }
    return $user;
});
# Test Event memo
Route::get('event-memo-test', function (Request $request) {
    $memo = MemoModel::first();
    if (request('event') == 'replay') {
        NotifyReplyMessageEvent::dispatch($memo);
    }
    if (request('event') == 'create') {
        NotifyNewMemo::dispatch($memo);
    }
    return 'Send Event Memo';
});
// WEB SOCKET FINISH
