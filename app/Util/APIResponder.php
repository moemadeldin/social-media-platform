<?php

declare(strict_types=1);

namespace App\Util;

use App\Enums\APIResponse;
use Illuminate\Http\JsonResponse;

trait APIResponder
{
    /**
     * trait used for implementing custom API Responses
     */
    public function successResponse($data = [], $message = null, int $code = 200): JsonResponse
    {
        return response()->json([
            'status' => APIResponse::SUCCESS_STATUS->value,
            'message' => $message ?? APIResponse::SUCCESS_MESSAGE->value,
            'data' => $data,
        ], $code);
    }

    public function failedResponse($message = null, int $code = 400): JsonResponse
    {
        return response()->json([
            'status' => APIResponse::FAILED_STATUS->value,
            'message' => $message ?? APIResponse::FAILED_MESSAGE->value,
        ], $code);
    }
}
