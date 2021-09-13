<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Http\Resources\Api\v1\BankStatusResource;
use App\Models\ConstantRekeningModel;
use App\Models\RekeningModel;

class BankController extends ApiController
{
    public function destination()
    {
        try {
            $destination = RekeningModel::leftJoin('constant_rekening as constRek', 'constRek.id', '=', 'rekening.constant_rekening_id')
                ->select([
                    'constRek.name',
                    'rekening.id as rekId',
                    'rekening.nama_rekening',
                    'rekening.nomor_rekening',
                ])
                ->where('rekening.is_depo', 1)
                ->orderBy('constant_rekening_id', 'asc')
                ->get();

            return $this->successResponse($destination);
        } catch (\Throwable $th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }

    public function availability()
    {
        try {
            $active = ConstantRekeningModel::where('is_bank', 1)->get();

            $inactive = ConstantRekeningModel::where('is_bank', 0)->get();

            $bank_status = [
                'active' => BankStatusResource::collection($active),
                'inactive' => BankStatusResource::collection($inactive),
            ];

            return $this->successResponse($bank_status);
        } catch (\Throwable $th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }

    public function bank()
    {
        try {
            $banks = ConstantRekeningModel::where('is_bank', 1)->pluck('name', 'id');

            $non_banks = ConstantRekeningModel::where('is_bank', 0)->pluck('name', 'id');

            $bank_status = [
                'bank' => $banks,
                'non_bank' => $non_banks,
            ];

            return $this->successResponse($bank_status);
        } catch (\Throwable $th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }
}
