<?php

namespace App\Lib;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator as FacadeValidator;

class Validator
{
    public function validate(Request $request, $data) {
        $validator = FacadeValidator::make($request->all(), $data);

        if($validator->fails()) {
            response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY)->send();
            exit();
        }
    }
}