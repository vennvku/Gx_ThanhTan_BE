<?php

namespace App\Traits;

use Closure;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ApiTrait
{
    /**
     * Success response data
     * @param array|object|null $data
     * @param int $statusCode
     */
    protected function respondSuccess(array|object|null $data, int $statusCode = Response::HTTP_OK): JsonResponse
    {
        return response()->json($data, $statusCode);
    }

    /**
     * Error response data
     * @param string $error
     * @param int $statusCode
     * @param array $data
     */
    protected function respondError(
        string $error,
        int $statusCode,
        array $data = []
    ): JsonResponse {
        $response = [
            'error' => $error,
        ];

        if (count($data)) {
            $response['details'] = $data;
        }

        return response()->json($response, $statusCode);
    }

}
