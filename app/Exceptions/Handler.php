<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Session\TokenMismatchException;
use Throwable;

class Handler extends ExceptionHandler
{
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

    /**
     * Main function for response exception
     *
     * @param $request
     * @param Throwable $e
     * @return Response|JsonResponse|\Symfony\Component\HttpFoundation\Response|RedirectResponse
     * @throws Throwable
     */
    public function render($request, Throwable $e): Response|JsonResponse|\Symfony\Component\HttpFoundation\Response|RedirectResponse
    {
        // Make sure to redirect to specified page instead of default 419 page
        if ($e instanceof TokenMismatchException) {
            return redirect()->route('homepage'); // FIXME: Replace to your route
        }

        return parent::render($request, $e);
    }
}
