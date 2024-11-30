<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExampleExcelExport
{
    use Exportable;

    /**
     * Handle export Excel file by template.
     *
     * @param array $data
     * @return StreamedResponse
     * @throws Exception
     */
    public function handle(array $data): StreamedResponse
    {
        if (empty($data)) {
            throw new Exception(__('messages.request.fail.exports.no_data'), Response::HTTP_NO_CONTENT);
        }

        $sheetNameExists = [];
        $template = public_path('assets/documents/example-template.xlsx');
        $originalFileName = basename($template);
        $spreadsheet = IOFactory::load($template);
        $worksheet = $spreadsheet->getActiveSheet();

        // Rename sheet
        $originalSheetName = 'Sheet';
        $worksheet->setTitle($originalSheetName);

        foreach ($data as $value) {
            // Get sheet name
            $sheetName = 'Example Sheet';
            $sheetName = str_replace(Worksheet::getInvalidCharacters(), '', $sheetName);
            $sheetName = mb_substr($sheetName, 0, 30);

            // If the names are the same, add a counting number
            if (in_array($sheetName, $sheetNameExists)) {
                $sheetNameCount = add_counting_number_to_identical_file_name($sheetName, $sheetNameExists);
                $sheetName .= ' (' . $sheetNameCount . ')';
            }

            $sheetNameExists[] = $sheetName;

            $newWorksheet = clone $worksheet;
            $newWorksheet->setTitle($sheetName);
            $spreadsheet->addSheet($newWorksheet);
            $this->_setValueToSheet($value, $newWorksheet);
            $this->_setStyleToSheet($newWorksheet);
        }

        // Remove original sheet
        $spreadsheet->removeSheetByIndex(
            $spreadsheet->getIndex(
                $spreadsheet->getSheetByName($originalSheetName)
            )
        );

        return $this->_streamExcel($spreadsheet, $originalFileName);
    }

    /**
     * Handle set value to sheet.
     *
     * @param array $value
     * @param Worksheet $worksheet
     * @return Worksheet
     * @throws Exception
     */
    private function _setValueToSheet(array $value, Worksheet $worksheet): Worksheet
    {
        $startRow = 2;

        foreach ($value as $item) {
            $worksheet->getCell('A' . $startRow)->setValue($item['id']);
            $worksheet->getCell('B' . $startRow)->setValue($item['name']);
            $worksheet->getCell('C' . $startRow)->setValue($item['email']);
            $startRow++;
        }

        return $worksheet;
    }

    /**
     * Handle set style to sheet.
     *
     * @param Worksheet $worksheet
     * @return Worksheet
     */
    private function _setStyleToSheet(Worksheet $worksheet): Worksheet
    {
        // Set auto-size for all columns
        foreach (range('A', $worksheet->getHighestColumn()) as $col) {
            $worksheet->getColumnDimension($col)->setAutoSize(true);
        }

        return $worksheet;
    }

    /**
     * Handle streamed response Excel file.
     *
     * @param Spreadsheet $spreadsheet
     * @param string $fileName
     * @return StreamedResponse
     */
    private function _streamExcel(Spreadsheet $spreadsheet, string $fileName): StreamedResponse
    {
        // Encode the file name for UTF-8 compatibility
        $encodedFileName = rawurlencode($fileName);
        $sanitizeFileName = sanitize_file_name($fileName);

        $response = new StreamedResponse(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        });
        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', "attachment; filename=\"$sanitizeFileName\"; filename*=utf-8''$encodedFileName");
        $response->headers->set('Cache-Control', 'max-age=0');

        return $response;
    }
}
