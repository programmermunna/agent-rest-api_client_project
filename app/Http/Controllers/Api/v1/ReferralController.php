<?php

namespace App\Http\Controllers\Api\v1;

use Hashids\Hashids;
use App\Models\MembersModel;
use App\Http\Controllers\ApiController;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\WithPagination;
use Illuminate\Pagination\Paginator;            # pagination pake ini
use Illuminate\Support\Collection;              # pagination pake ini
use DB;

class ReferralController extends ApiController
{
    use WithPagination;
     protected $member;
     public $refList = [];
     public $perPage=20;

    public function __construct()
    {
        $this->member = auth('api')->user();
    }

    public function paginate($items, $perPage, $page = null, $options = []){
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function code()
    {
        try {
            $hashids = new Hashids('', 6);
            $idCode = $hashids->encode($this->member->id);

            return $this->successResponse($idCode);
        } catch (\Throwable $th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }

    public function list()
    {
        try {
            $qRefList = MembersModel::where('referrer_id', auth('api')->user()->id)
            ->where('status', 1)
            ->select([
                'id', 'referrer_id', 'bonus_referal', 'username',
            ])
            ->get();
            $this->refList = $qRefList->toArray();
            $referralList = $this->paginate($this->refList,$this->perPage);
            return $this->successResponse($referralList, 200);
        } catch (\Throwable $th) {
            return $this->errorResponse('Internal Server Error', 500);
        }

    }
}
