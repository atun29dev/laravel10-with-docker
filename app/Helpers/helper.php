<?php

if (!function_exists('throw_exception')) {
    /**
     * Handle throw custom exception
     *
     * @param string $msg
     * @param int $statusCode
     * @return mixed
     * @throws \App\Exceptions\CustomException
     */
    function throw_exception(string $msg = '', int $statusCode = \Symfony\Component\HttpFoundation\Response::HTTP_INTERNAL_SERVER_ERROR): mixed
    {
        throw new \App\Exceptions\CustomException($msg, $statusCode);
    }
}
