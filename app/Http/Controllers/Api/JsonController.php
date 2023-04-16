<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class JsonController extends Controller
{
    protected function noContentResponse(): JsonResponse
    {
        return $this->response(null, 204);
    }

    protected function response(?array $data, int $code = 200): JsonResponse
    {
        return response()->json(
            $data !== null ?
                [
                    'data' => $data,
                ] :
                null,
            $code
        );
    }

    protected function createdResponse(): JsonResponse
    {
        return $this->response(null, 201);
    }

    protected function errorResponse(string $message, int $code = 400): JsonResponse
    {
        return response()->json([
            'message' => $message,
        ], $code);
    }
}
