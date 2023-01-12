<?php

namespace App\Http\Controllers\Api\v1;

use App\Events\NotifyNewMemo;
use App\Events\NotifyReadMessageEvent;
use App\Events\NotifyReplyMessageEvent;
use App\Http\Controllers\ApiController;
use App\Models\MemoModel;
use App\Models\UserLogModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection; # pagination pake ini
use Illuminate\Support\Facades\Log; # pagination pake ini
use Illuminate\Support\Facades\Validator; # pagination pake ini
use Livewire\WithPagination;

class MemoController extends ApiController
{
    use WithPagination;
    public $perPage = 20;
    public $memoId;
    public $memoData = [];
    public $inbox = [];
    public $modMemberId;
    public $subject;
    public $modMemberName;

    // post

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required',
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Kesalahan Validasi', 422, $validator->errors()->first());
        }
        try {
            $createAndGetId = MemoModel::insertGetId([
                'member_id' => auth('api')->user()->id,
                'sender_id' => auth('api')->user()->id,
                'send_type' => 'Member',
                'subject' => $request->subject,
                'is_sent' => 1,
                'content' => $request->content,
                'created_at' => Carbon::now(),
            ]);

            $memo = MemoModel::where('id', $createAndGetId)->first();

            // WEB SOCKET START
            // ========================================================
            NotifyNewMemo::dispatch($memo);
            // ========================================================
            // WEB SOCKET FINISH

            $user = auth('api')->user();
            UserLogModel::logMemberActivity(
                'Memo Created',
                $user,
                $memo,
                [
                    'target' => "memo {$memo->subject}",
                    'activity' => 'Create',
                    'ip_member' => auth('api')->user()->last_login_ip,
                ],
                "$user->username Created a Memo"
            );

            return $this->successResponse(null, 'Berhasil membuat memo', 200);
        } catch (\Exception$e) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }

    public function inbox()
    {
        try {
            $memo = MemoModel::select(['id', 'member_id', 'sender_id', 'is_read', 'subject', 'content', 'created_at'])
                ->where('member_id', auth('api')->user()->id)
                ->orderBy('id', 'desc')
                ->where('memo_id', null)
                ->with(['subMemos' => function ($query) {
                    $query->select('memo_id', 'id', 'member_id', 'sender_id', 'is_read', 'subject', 'content', 'created_at');
                }])
                ->get();
            $this->inbox = $memo->toArray();
            $inbox = $this->paginate($this->inbox, $this->perPage);
            return $this->successResponse($inbox, 200);
        } catch (\Throwable$th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }

    public function paginate($items, $perPage, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
    public function sent()
    {
        try {
            $memo = MemoModel::select(['id', 'member_id', 'sender_id', 'is_read', 'subject', 'content', 'created_at'])
                ->where('member_id', auth('api')->user()->id)
                ->orderBy('id', 'desc')
                ->where('is_sent', 1)
                ->where('memo_id', null)
                ->with(['subMemos' => function ($query) {
                    $query->select('memo_id', 'id', 'member_id', 'sender_id', 'is_read', 'subject', 'content', 'created_at');
                }])
                ->get();
            $this->inbox = $memo->toArray();
            $inbox = $this->paginate($this->inbox, $this->perPage);
            return $this->successResponse($inbox, 200);
        } catch (\Throwable$th) {
            return $this->errorResponse('Internal Server Error', 500);
        }

    }
    // post
    public function read(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse('Kesalahan validasi', 422, $validator->errors()->first());
            }

            $memo = MemoModel::select('id','is_read', 'memo_id')->find($request->id);
            if ($memo->memo_id != null) {
                $memo->update([
                    'is_read' => 1,
                ]);
            }

            // WEB SOCKET START
            NotifyReadMessageEvent::dispatch(MemoModel::find($request->id));
            // WEB SOCKET FINISH

            return $this->successResponse($request->id);
        } catch (\Throwable$th) {
            Log::error($th->getMessage());
            return $this->errorResponse('Internal Server Error', 500);
        }

    }

    // post
    public function reply(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required',
            'subject' => 'required',
            'memoId' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Kesalahan validasi', 422, $validator->errors()->first());
        }
        try {
            $createAndGetId = MemoModel::insertGetId([
                'member_id' => auth('api')->user()->id,
                'memo_id' => $request->memoId,
                'is_sent' => 1,
                'sender_id' => auth('api')->user()->id,
                'send_type' => 'Member',
                'subject' => $request->subject,
                'content' => $request->content,
                'created_at' => Carbon::now(),
            ]);
            MemoModel::where('id', $request->memoId)
                ->update([
                    'is_sent' => 1,
                ]);

            $memo = MemoModel::where('id', $createAndGetId)->first();

            // WEB SOCKET START
            // ========================================================
            NotifyReplyMessageEvent::dispatch($memo);
            // ========================================================
            // WEB SOCKET FINISH

            $user = auth('api')->user();
            UserLogModel::logMemberActivity(
                'Memo Created',
                $user,
                $memo,
                [
                    'target' => "memo {$memo->subject}",
                    'activity' => 'Replied to a memo',
                    'ip_member' => auth('api')->user()->last_login_ip,
                ],
                "$user->username Replied a Memo"
            );
            auth('api')->user()->update([
                'last_login_ip' => $request->ip,
            ]);

            return $this->successResponse(null, 'Berhasil membalas memo', 200);
        } catch (\Exception$e) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }

    public function detail($index)
    {
        # detail u/ di header
        $dataMemo = MemoModel::find($index);
        // dd($dataMemo);
        $this->memoId = $dataMemo->id;
        $this->memoData = $dataMemo;
        // dd($this->memoData);
        $this->modMemberId = $dataMemo->member->id;
        $this->subject = 'RE: ' . $dataMemo['subject'];

        $data = [
            'memoId' => $this->memoId,
            'subject' => $this->subject,
            'memoData' => $this->memoData,
            'modMemberId' => $this->modMemberId,
        ];
        return $this->successResponse($data, 'Detail memo', 201);
    }
    public function NotifyMemo()
    {
        try {
            $notify = MemoModel::select('id')->where('is_read', false)->whereIn('send_type', ['Admin', 'System'])->count();
            return response()->json([
                'status' => 'success',
                'message' => null,
                'data' => [
                    'notify' => $notify > 9 ? '9+' : $notify
                ]
            ]);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Bad request',
                'data' => null,
            ], 500);
        }
    }
}
