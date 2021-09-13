<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactUsController extends ApiController
{
    public function create(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_name' => 'required|string|between:3,100',
                'destination' => 'required',
                'message' => 'required|string|between:10,9000',
                'number' => 'required|string',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse('Validation Error', 422, $validator->errors()->first());
            }
            ContactUs::create($request->all());

            return $this->successResponse(null, 'Contact Create successfully.', 201);
        } catch (\Throwable $th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }
}
