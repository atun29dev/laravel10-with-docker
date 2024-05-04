<?php

use App\Exceptions\CustomException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

if (!function_exists('throw_exception')) {
    /**
     * Handle throw custom exception
     *
     * @param string $msg
     * @param int $statusCode
     * @return mixed
     * @throws CustomException
     */
    function throw_exception(string $msg = '', int $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR): mixed
    {
        throw new CustomException($msg, $statusCode);
    }
}

if (!function_exists('convert_to_pagination')) {
    /**
     * Convert array or collection to pagination
     *
     * @param $data
     * @param int $perPage
     * @param int $page
     * @param array $options
     * @return LengthAwarePaginator
     */
    function convert_to_pagination($data, int $perPage = \App\Enums\PaginationEnum::LIMIT_DEFAULT, int $page = \App\Enums\PaginationEnum::PAGE_DEFAULT, array $options = []): LengthAwarePaginator
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $collectionData = $data instanceof Collection ? $data : Collection::make($data);

        return new LengthAwarePaginator($collectionData->forPage($page, $perPage), $collectionData->count(), $perPage, $page, $options);
    }
}

if (!function_exists('custom_pagination')) {
    /**
     * Custom pagination
     *
     * @param string $dataKey
     * @param array|Collection|LengthAwarePaginator $data
     * @return array
     */
    function custom_pagination(string $dataKey = 'data', array|Collection|LengthAwarePaginator $data = []): array
    {
        if ($data instanceof LengthAwarePaginator) {
            return [
                $dataKey => $data->all(),
                'page' => (int) $data->currentPage(),
                'limit' => (int) $data->perPage(),
                'currents' => (int) $data->count(),
                'totals' => (int) $data->total(),
            ];
        } else {
            return [
                $dataKey => is_array($data) ? $data : $data->all(),
            ];
        }
    }
}
