<?php

namespace App\Http\Controllers\Web;

use App\Enums\ExampleExcelExportDataEnum;
use App\Exports\ExampleExcelExport;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    /**
     * Handle export Excel file.
     *
     * @param Request $request
     * @param ExampleExcelExport $export
     * @return RedirectResponse|StreamedResponse
     */
    public function exportExcel(Request $request, ExampleExcelExport $export): StreamedResponse|RedirectResponse
    {
        try {
            $exampleData = ExampleExcelExportDataEnum::DATA;

            return $export->handle($exampleData);
        } catch (Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
}
