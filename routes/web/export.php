<?php

use App\Http\Controllers\Web\ExportController;
use Illuminate\Support\Facades\Route;

Route::prefix('exports')->as('export.')->group(function () {
    Route::get('/excel', [ExportController::class, 'exportExcel'])->name('excel');
});
