<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ExcelExporter
{
    protected $data;
    protected $headers;
    protected $filename;

    /**
     * @param array $data Array de datos (array de arrays u objetos)
     * @param array $headers Array asociativo ['clave' => 'Título de columna']
     * @param string $filename Nombre del archivo para descarga
     */
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

        // Insertar logo en A1
        $drawing = new Drawing();
        $drawing->setName('Logo Empresa');
        $drawing->setDescription('Logo Empresa');
        $drawing->setPath(public_path('images/logo_empresa.png'));
        $drawing->setHeight(60);
        $drawing->setCoordinates('A1');
        $drawing->setOffsetX(10);
        $drawing->setOffsetY(5);
        $drawing->setWorksheet($sheet);

        // Ajustar altura fila 1 para que no tape el logo
        $sheet->getRowDimension(1)->setRowHeight(60);

        // Definir fila donde empiezan los encabezados, justo debajo del logo
        $headerRow = 3;

        // Escribir encabezados
        $colIndex = 1;
        foreach ($this->headers as $header) {
            $cell = Coordinate::stringFromColumnIndex($colIndex) . $headerRow;
            $sheet->setCellValue($cell, $header);
            $colIndex++;
        }

        // Aplicar estilo a encabezados (fila de encabezados)
        $lastCol = Coordinate::stringFromColumnIndex(count($this->headers));
        $headerRange = "A{$headerRow}:{$lastCol}{$headerRow}";

        $sheet->getStyle($headerRange)->getFont()->setBold(true);
        $sheet->getStyle($headerRange)->getFill()->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('e1d6b4');
        $sheet->getStyle($headerRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Escribir datos desde fila siguiente a encabezados
        $rowIndex = $headerRow + 1;
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

        // Autoajustar ancho columnas
        foreach (range('A', $lastCol) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Agregar bordes a toda la tabla (encabezados + datos)
        $dataEndRow = $rowIndex - 1;
        $tableRange = "A{$headerRow}:{$lastCol}{$dataEndRow}";
        $sheet->getStyle($tableRange)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)
            ->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF000000'));

        // Opcional: centrar columnas específicas, ejemplo Stock Actual y Stock Mínimo
        // Ajusta según tus columnas, aquí por ejemplo D y E
        $sheet->getStyle("D" . ($headerRow + 1) . ":E{$dataEndRow}")
            ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Crear writer para Excel
        $writer = new Xlsx($spreadsheet);

        // Headers HTTP para descarga
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"{$this->filename}\"");
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
