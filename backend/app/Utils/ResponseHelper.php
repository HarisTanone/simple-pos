<?php

namespace App\Utils;

use App\Http\Resources\SuccessResource;
use App\Http\Resources\ErrorResource;

class ResponseHelper
{
    public static function success($data = null, string $message = 'Success', int $statusCode = 200)
    {
        return response()->json(new SuccessResource($data, $message, $statusCode), $statusCode);
    }

    public static function error(string $message = 'Error', int $statusCode = 400, $errors = null)
    {
        return response()->json(new ErrorResource($message, $statusCode, $errors), $statusCode);
    }
}
