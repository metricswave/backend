<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class JsonController extends Controller
{
    protected function response(array $data, int $code = 200): JsonResponse
    {
        return response()->json([
            'data' => $data,
        ], $code);
    }

    protected function errorResponse(string $message, int $code = 400): JsonResponse
    {
        return response()->json([
            'message' => $message,
        ], $code);
    }
}
