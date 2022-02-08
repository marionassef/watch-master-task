<?php


namespace App\Helpers;


use Illuminate\Http\JsonResponse;

class CustomResponse
{
    /**
     * @param $message
     * @param array $data
     * @param int $status
     * @return JsonResponse
     */
    public static function successResponse($message, $data = [], int $status = 200): JsonResponse
    {
        return response()->json(['message' => $message, 'data' => $data], $status);
    }

    /**
     * @param $message
     * @param int $status
     * @param string $error
     * @return JsonResponse
     */
    public static function errorResponse($message, int $status = 400, string $error = ''): JsonResponse
    {
        return response()->json(['message' => $message, 'error' => $error], $status);
    }
}
