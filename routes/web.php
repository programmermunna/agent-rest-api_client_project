<?php

// use App\Http\Controllers\LocaleController;
// use App\Http\Controllers\Api\v1\MemberController;
// use App\Http\Controllers\Backend\BonusController;

/*
 * Global Routes
 *
 * Routes that are used between both frontend and backend.
 */

// Switch between the included languages
Route::get('/', function(){
 return json_encode('success');
});

Route::get('/test-create-event', function (Request $request) {

    \App\Models\MemoModel::create([
        'member_id' => request('member_id') ?? 1,
        'subject' => 'Test',
        'content' => 'Test',
        //'send_type' => 'Test',
        'is_sent' => 1,
        'is_reply' => 0,
        'is_read' => 0,
        //'memo_id',
        'is_bonus' => 0,
        'sender_id' => request('sender_id') ?? 1,
        'created_by' => request('created_by') ?? 1
    ]);

    return 'memo created';
});
