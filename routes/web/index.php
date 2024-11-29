<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.welcome');
})->name('homepage');

Route::group([], base_path('routes/web/export.php'));
