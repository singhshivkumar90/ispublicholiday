<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    /**
     * @param $responseData
     * @param int $responseCode
     * @param string $message
     * @param array $headers
     * @return JsonResponse
     */
    public function sendResponse($responseData, int $responseCode, $message = '', array $headers = []) : JsonResponse
    {
        return response()->json(
            ['data' => $responseData, 'message' => $message],
            $responseCode,
            $headers
        );
    }
}
