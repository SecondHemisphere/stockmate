<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ExcelExporter
{
    protected $data;
    protected $headers;
    protected $filename;

    public function __construct(array $data, array $headers, string $filename = 'export.xlsx')
    {
        $this->data = $data;
        $this->headers = $headers;
        $this->filename = $filename;
    }

    public function export()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Escribir encabezados en fila 1
        $colIndex = 1;
        foreach ($this->headers as $header) {
            $cell = Coordinate::stringFromColumnIndex($colIndex) . '1';
            $sheet->setCellValue($cell, $header);
            $colIndex++;
        }

        // Aplicar estilo a encabezados (fila 1)
        $lastCol = Coordinate::stringFromColumnIndex(count($this->headers));
        $headerRange = "A1:{$lastCol}1";

        // Fondo amarillo claro y texto en negrita
        $sheet->getStyle($headerRange)->getFont()->setBold(true);
        $sheet->getStyle($headerRange)->getFill()->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFACD'); // Color LemonChiffon (amarillo claro)

        // Alinear encabezados al centro
        $sheet->getStyle($headerRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Escribir datos a partir de fila 2
        $rowIndex = 2;
        foreach ($this->data as $row) {
            $colIndex = 1;
            foreach ($this->headers as $key => $header) {
                if (is_array($row)) {
                    $value = $row[$key] ?? '';
                } elseif (is_object($row)) {
                    $value = $row->$key ?? '';
                } else {
                    $value = '';
                }
                $cell = Coordinate::stringFromColumnIndex($colIndex) . $rowIndex;
                $sheet->setCellValue($cell, $value);
                $colIndex++;
            }
            $rowIndex++;
        }

        // Autoajustar ancho de columnas
        foreach (range('A', $lastCol) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Agregar bordes a toda la tabla (desde A1 hasta última fila y columna)
        $dataEndRow = $rowIndex - 1;
        $tableRange = "A1:{$lastCol}{$dataEndRow}";

        $sheet->getStyle($tableRange)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)
            ->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF000000'));

        // Opcional: centrar texto en columnas específicas, ejemplo Stock Actual y Stock Mínimo (D y E)
        $sheet->getStyle("D2:E{$dataEndRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Crear writer para Excel
        $writer = new Xlsx($spreadsheet);

        // Enviar headers HTTP para descarga
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"{$this->filename}\"");
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
