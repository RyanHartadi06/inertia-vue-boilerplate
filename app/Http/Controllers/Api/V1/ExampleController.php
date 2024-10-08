<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExampleController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $resources = [
            [
                'id'    => 1,
                'name'  => 'John Doe',
            ],
            [
                'id'    => 2,
                'name'  => 'Jane Doe',
            ],
        ];

        return $this->resourcesDataResponse('Example response', $resources);
    }
}
