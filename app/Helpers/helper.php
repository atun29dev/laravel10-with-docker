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
