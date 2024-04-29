<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\RecordsNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|Response
     * @throws Throwable
     */
    public function render($request, Throwable $e): \Illuminate\Http\Response|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|Response
    {
        if (Str::startsWith($request->path(), 'api/')) {
            return $this->_responseErrors($request, $e);
        }

        $statusCode = method_exists($e, 'getStatusCode') ?
            $e->getStatusCode() :
            $e->status ?? Response::HTTP_INTERNAL_SERVER_ERROR;

        if ($statusCode == Response::HTTP_NOT_FOUND) {
            return response(
                __('messages.error.api_environment'),
                Response::HTTP_NOT_FOUND
            );
        }

        return parent::render($request, $e);
    }

    /**
     * Handle response exception
     *
     * @param $request
     * @param $e
     * @return \Illuminate\Http\JsonResponse
     */
    private function _responseErrors($request, $e): \Illuminate\Http\JsonResponse
    {
        if ($e instanceof AuthenticationException) {
            return $this->_authenticationException($e);
        } elseif ($e instanceof AuthorizationException) {
            return $this->_authorizationException($e);
        } elseif ($e instanceof ValidationException) {
            return $this->_validationException($e);
        } elseif ($e instanceof NotFoundHttpException) {
            return $this->_httpNotFoundException($e);
        } elseif ($e instanceof ModelNotFoundException) {
            // Response error when using a query like ID
            return $this->_modelNotFoundException($e);
        } elseif ($e instanceof RecordsNotFoundException) {
            // Response error when using multiple complex queries
            return $this->_recordNotFoundException($e);
        } elseif ($e instanceof CustomException) {
            return $this->_customException($e);
        } else {
            return $this->_globalException($e);
        }
    }

    /**
     * Formatting response
     *
     * @param string $msg
     * @return array|string[]
     */
    private function _formatResponse(string $msg): array
    {
        return ['message' => $msg];
    }

    /**
     * Handle authentication exception
     *
     * @param $e
     * @return \Illuminate\Http\JsonResponse
     */
    private function _authenticationException($e): \Illuminate\Http\JsonResponse
    {
        return response()->json($this->_formatResponse($e->getMessage()), Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Handle authorization exception
     *
     * @param $e
     * @return \Illuminate\Http\JsonResponse
     */
    private function _authorizationException($e): \Illuminate\Http\JsonResponse
    {
        return response()->json($this->_formatResponse($e->getMessage()), Response::HTTP_FORBIDDEN);
    }

    /**
     * Handle validation exception
     *
     * @param $e
     * @return \Illuminate\Http\JsonResponse
     */
    private function _validationException($e): \Illuminate\Http\JsonResponse
    {
        // Retrieve the first error
        $msg = '';

        foreach ($e->errors() as $msg) {
            $msg = $msg[0];
        }

        return response()->json($this->_formatResponse($msg), Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Handle http not found exception
     *
     * @param $e
     * @return \Illuminate\Http\JsonResponse
     */
    private function _httpNotFoundException($e): \Illuminate\Http\JsonResponse
    {
        return response()->json($this->_formatResponse($e->getMessage()), Response::HTTP_NOT_FOUND);
    }

    /**
     * Handle model not found exception
     *
     * @param $e
     * @return \Illuminate\Http\JsonResponse
     */
    private function _modelNotFoundException($e): \Illuminate\Http\JsonResponse
    {
        return response()->json($this->_formatResponse('model not found'), Response::HTTP_NOT_FOUND);
    }

    /**
     * Handle record not found exception
     *
     * @param $e
     * @return \Illuminate\Http\JsonResponse
     */
    private function _recordNotFoundException($e): \Illuminate\Http\JsonResponse
    {
        return response()->json($this->_formatResponse($e->getMessage()), Response::HTTP_NOT_FOUND);
    }

    /**
     * Handle custom exception
     *
     * @param $e
     * @return \Illuminate\Http\JsonResponse
     */
    private function _customException($e): \Illuminate\Http\JsonResponse
    {
        return response()->json($this->_formatResponse($e->getMessage()), $e->getStatusCode());
    }

    /**
     * Handle global exception
     *
     * @param $e
     * @return \Illuminate\Http\JsonResponse
     */
    private function _globalException($e): \Illuminate\Http\JsonResponse
    {
        return response()->json($this->_formatResponse($e->getMessage()), Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
