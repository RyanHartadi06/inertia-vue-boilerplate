<?php 

namespace App\Http\Controllers\Api;

trait ApiResponse
{
    /**
     * response for POST request
     * to indicate the data was saved successfuly
     */
    public function singleDataSaveResponse(string $message, $data = null, int $httpStatusCode = 201)
    {
        return response()->json([
            'message'   => $message,
            'data'      => $data
        ], $httpStatusCode);
    }

    public function singleDataResponse(string $message, $data = null, int $httpStatusCode = 200)
    {
        return response()->json([
            'message'   => $message,
            'data'      => $data
        ], $httpStatusCode);
    }

    public function resourcesDataResponse(string $message, array $data = [], int $httpStatusCode = 200)
    {
        return response()->json([
            'message'   => $message,
            'data'      => $data
        ], $httpStatusCode);
    }

    public function resourcesPaginationResponse(string $message, $resources, int $httpStatusCode = 200)
    {
        return response()->json([
            'message'   => $message,
            'data'      => [
                'pagination'    => [
                    'current_page'  => $resources->currentPage(),
                    'last_page'     => $resources->lastPage(),
                    'per_page'      => $resources->perPage(),
                    'total'         => $resources->total(),
                ],
                'data'          => $resources->items(),
            ]
        ], $httpStatusCode);
    }

    public function errorResponse(string $message, $data = null, int $httpStatusCode = 402)
    {
        return response()->json([
            'message'   => $message,
            'data'      => $data
        ], $httpStatusCode);
    }
}

