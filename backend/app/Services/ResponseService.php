<?php

namespace App\Services;

class ResponseService
{
    public static function jsonResponse(
        int $statusCode,
        string $status = 'success',
        string $message = '',
        $data,
    ): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }
}
