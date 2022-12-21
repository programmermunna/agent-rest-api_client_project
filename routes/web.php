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
use Spatie\WebhookServer\WebhookCall;

Route::get('/', function () {
    return json_encode('success');
});

// WEBHOOK START
Route::webhooks('webhooks-message');
Route::get('/test-webhook', function () {
    WebhookCall::create()
        ->url('http://localhost:8001/new-memo-event')
        ->payload(['memo_id' => 5])
        ->useSecret('Cikatech')
        ->dispatch();
});
// WEBHOOK FINISH

// todo remove this before PR to production
// WEB SOCKET START
// Route::get('/test-create-event', function (Request $request) {

//     if (config('app.env') !== 'production') {
//         \App\Models\MemoModel::create([
//             'member_id' => request('member_id') ?? 1,
//             'subject' => 'Test',
//             'content' => 'Test',
//             //'send_type' => 'Test',
//             'is_sent' => 1,
//             'is_reply' => 0,
//             'is_read' => false,
//             //'memo_id',
//             'is_bonus' => 0,
//             'sender_id' => request('sender_id') ?? 1,
//             'created_by' => request('created_by') ?? 1,
//         ]);

//         return 'memo created';
//     }

//     return 'memo not created';
// });

// Route::get('/withdrawal-create-event', function (Request $request) {

//     if (config('app.env') !== 'production') {
//         $payload = [
//             'members_id' => request('members_id') ?? 1,
//             'rekening_id' => request('rekening_id') ?? 1,
//             'rek_member_id' => request('rek_member_id') ?? 1,
//             'jumlah' => 88,
//             'credit' => 6,
//             'note' => 'testing',
//             //'is_claim_bonus_freebet' => 1,
//             'created_by' => request('members_id') ?? 1,
//             'created_at' => Carbon::now(),
//         ];
//         \App\Models\WithdrawModel::create($payload);

//         return 'withdrawal created';
//     }

//     return 'withdrawal not created';
// });
// WEB SOCKET END
