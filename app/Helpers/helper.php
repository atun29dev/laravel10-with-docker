<?php

if (!function_exists('add_counting_number_to_identical_file_name')) {
    /**
     * Handle add counting number to identical file name.
     *
     * @param string $fileName
     * @param array $fileNameExists
     * @return mixed
     */
    function add_counting_number_to_identical_file_name(string $fileName, array $fileNameExists): mixed
    {
        $fileNameExists = array_map(function ($value) {
            return preg_replace('/\s*\(\d+\)/', '', $value); // Remove counting number. Ex: `Name (1)` => `Name`
        }, $fileNameExists);
        $fileNameExistsCountValues = array_count_values($fileNameExists);

        return $fileNameExistsCountValues[$fileName];
    }
}

if (!function_exists('sanitize_file_name')) {
    /**
     * Handle sanitize file name. Replace all non-printable characters with `-`.
     *
     * @param string $fileName
     * @return array|string|null
     */
    function sanitize_file_name(string $fileName): array|string|null
    {
        $regexPattern = '/[^\x20-\x7E]/';
        $sanitizedFileName = preg_replace($regexPattern, '-', $fileName);

        return preg_replace('/-+/', '-', $sanitizedFileName);
    }
}
