<?php

namespace App\Exceptions;

use App\Http\Controllers\Api\ApiResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Inertia\Inertia;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponse;

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        $response = parent::render($request, $e);
        $res = parent::convertExceptionToArray($e);

        if (! $request->expectsJson()) {
            if (!config('app.debug') && in_array($response->status(), [500, 503, 400, 403, 404])) {
                $view = 'Errors/Basic';
                if ($response->status() == 404) {
                    $view = 'Errors/404';
                } else if ($response->status() == 500) {
                    $view = 'Errors/500';
                }

                return Inertia::render($view, [
                    'title'     => 'Error',
                    'status'    => $response->status(),
                    'message'   => $res['message'],
                    ])
                    ->toResponse($request)
                    ->setStatusCode($response->status());
            } else if ($response->status() === 419) {
                return back()->with([
                    'message' => 'The page expired, please try again.',
                ]);
            }
        } else {
            return $this->errorResponse($res['message'], null, $response->status());
        }

        return $response;
    }
}
