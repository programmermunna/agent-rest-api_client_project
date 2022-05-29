<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\MemoModel;
use App\Models\UserLogModel;
use Illuminate\Http\Request;
use App\Models\MembersModel;
use Carbon\Carbon;
use Livewire\WithPagination;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Api\v1\MemoResource;
use Illuminate\Pagination\Paginator;            # pagination pake ini
use Illuminate\Support\Collection;              # pagination pake ini
use Illuminate\Pagination\LengthAwarePaginator; # pagination pake ini
use Illuminate\Support\Facades\Log;

class MemoController extends ApiController
{
    use WithPagination;
    public $perPage=20;
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
            $memo = MemoModel::create([
                'member_id' => auth('api')->user()->id,
                'sender_id' => auth('api')->user()->id,
                'send_type' => 'Member',
                'subject' => $request->subject,
                'is_sent' => 1,
                'content' => $request->content,
                'created_at' => Carbon::now(),
            ]);

            $user = auth('api')->user();
            UserLogModel::logMemberActivity(
                'Memo Created',
                $user,
                $memo,
                [
                    'target' => "memo {$memo->subject}",
                    'activity' => 'Create',
                ],
                "$user->username Created a Memo"
            );
            auth('api')->user()->update([
                'last_login_ip' => $request->ip,
            ]);

            // MemoModel::insert($create);
            return $this->successResponse(null, 'Berhasil membuat memo', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }

    public function inbox()
    {
        try {
            $memo = MemoModel::where('member_id', auth('api')->user()->id)
            ->where('is_reply', 1)
            ->orderBy('id', 'desc')
            ->where('memo_id', null)
            ->with(['subMemos'])
            // ->whereHas('subMemos', function($q){
            //     $q->whereNotNull('id');
            // })
            ->get();
            $this->inbox = $memo->toArray();
            // dd($this->inbox);
            $inbox = $this->paginate($this->inbox,$this->perPage);
            return $this->successResponse($inbox, 200);
        } catch (\Throwable $th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }

    public function paginate($items, $perPage, $page = null, $options = []){
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
    public function sent()
    {
        try {
            $memo = MemoModel::where('member_id', auth('api')->user()->id)
            ->orderBy('id', 'desc')
            ->where('is_sent', 1)
            ->where('memo_id', null)
            ->with(['subMemos'])
            ->get();
            $this->inbox = $memo->toArray();
            $inbox = $this->paginate($this->inbox,$this->perPage);
            return $this->successResponse($inbox, 200);
        } catch (\Throwable $th) {
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
            MemoModel::where('id', $request->id)->orWhere('memo_id', $request->id)
            ->update([
                'is_read' => 1,
            ]);

            if ($validator->fails()) {
                return $this->errorResponse('Kesalahan validasi', 422, $validator->errors()->first());
            }

            return $this->successResponse($request->id);
        } catch (\Throwable $th) {
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
            $memo = MemoModel::create([
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

            $user = auth('api')->user();
            UserLogModel::logMemberActivity(
                'Memo Created',
                $user,
                $memo,
                [
                    'target' => "memo {$memo->subject}",
                    'activity' => 'Replied to a memo',
                ],
                "$user->username Replied a Memo"
            );
            auth('api')->user()->update([
                'last_login_ip' => $request->ip,
            ]);
            // MemoModel::insert($create);
            return $this->successResponse(null, 'Berhasil membalas memo', 200);
        } catch (\Exception $e) {
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
        $this->subject = 'RE: '.$dataMemo['subject'];

        $data = [
            'memoId' => $this->memoId,
            'subject' => $this->subject,
            'memoData' =>  $this->memoData,
            'modMemberId' =>  $this->modMemberId
        ];
        return $this->successResponse($data , 'Detail memo', 201);
    }
}
