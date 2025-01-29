<?php

namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    protected function errorResponse(
        string $message,
        array $errors = [],
        int $status = 400
    ): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }

    protected function successResponse(
        string $message,
        array|object $data = [],
        int $status = 200
    ): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $status);
    }
}
