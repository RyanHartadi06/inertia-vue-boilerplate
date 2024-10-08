<?php

namespace App\Http\Controllers;

use App\Libraries\Resource\Paginator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, DispatchesJobs, Paginator;

    protected function simpleResourceAdditionalData($request, $resources, $filters = [])
    {
        return [
            'links'         => $this->extend($request, $resources),
            'pagination'    => [
                'current_page'  => $resources->currentPage(),
                'last_page'     => $resources->lastPage(),
                'next_page_url' => $resources->nextPageUrl(),
                'path'          => $resources->path(),
                'per_page'      => $resources->perPage(),
                'total'         => $resources->total(),
            ],
            'filters'       => $filters,
            'requestQuery'  => $request->all(),
        ];
    }
}
