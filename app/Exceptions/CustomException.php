<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class CustomException extends Exception
{
    private mixed $statusCode;

    /**
     * Construction
     *
     * @param $massage
     * @param $statusCode
     * @param \Throwable|null $previous
     */
    public function __construct($massage = '', $statusCode = Response::HTTP_BAD_REQUEST, \Throwable $previous = null)
    {
        parent::__construct($massage, $statusCode, $previous);
        $this->statusCode = $statusCode;
    }

    /**
     * Retrieve the HTTP status code
     *
     * @return int|mixed
     */
    public function getStatusCode(): mixed
    {
        return $this->statusCode;
    }
}
