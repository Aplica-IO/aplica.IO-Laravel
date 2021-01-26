<?php
namespace App\Helpers;

use Illuminate\Http\Response;

class ApiHelpers {

    /**
     * Generic API response structure for all requests
     *
     * @param $code string
     * @param $response mixed
     * @return \Illuminate\Http\JsonResponse
     */
    public static function ApiResponse($code, $message, $response)
    {
        return response()->json([
            'message'  => $message,
            'response' => $response
        ], $code);
    }
}
