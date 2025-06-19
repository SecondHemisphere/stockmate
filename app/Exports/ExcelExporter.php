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
    protected $user;

    /**
     * @param array $data Array de datos (array de arrays u objetos)
     * @param array $headers Array asociativo ['clave' => 'Título de columna']
     * @param string $filename Nombre del archivo para descarga
     * @param string|null $user Nombre del usuario que genera el reporte
     */
    public function __construct(array $data, array $headers, string $filename = 'export.xlsx', ?string $user = null)
    {
        $this->data = $data;
        $this->headers = $headers;
        $this->filename = $filename;
        $this->user = $user;
    }

    public function export()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Insertar logo en A1
        $drawing = new Drawing();
        $drawing->setName('Logo Empresa');
        $drawing->setDescription('Logo Empresa');
        $drawing->setPath(public_path('images/logo_empresa.png')); // Ajusta la ruta a tu logo
        $drawing->setHeight(60);
        $drawing->setCoordinates('B1');
        $drawing->setOffsetX(10);
        $drawing->setOffsetY(5);
        $drawing->setWorksheet($sheet);

        // Ajustar altura fila 1 para el logo
        $sheet->getRowDimension(1)->setRowHeight(60);

        // Escribir info empresa y usuario en fila 2, desde columna A hacia la derecha
        $companyName = 'Lapiz Veloz';
        $userName = auth()->user()->nombre ?? 'Sistema';
        $currentDate = date('d/m/Y H:i');

        $sheet->setCellValue('B2', "Empresa: $companyName");
        $sheet->setCellValue('C2', "Generado Por: $userName");
        $sheet->setCellValue('D2', "Fecha: $currentDate");

        // Estilos para esa fila 2 (negrita y tamaño fuente)
        $sheet->getStyle('A2:F2')->getFont()->setBold(true)->setSize(11);
        // Puedes centrar los textos si quieres
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('C2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('F2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        // Altura fila 2
        $sheet->getRowDimension(2)->setRowHeight(20);

        // Definir fila donde empiezan los encabezados, justo debajo del logo e info
        $headerRow = 4;

        // Escribir encabezados
        $colIndex = 1;
        foreach ($this->headers as $header) {
            $cell = Coordinate::stringFromColumnIndex($colIndex) . $headerRow;
            $sheet->setCellValue($cell, $header);
            $colIndex++;
        }

        // Estilos encabezados
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

        // Bordes tabla (encabezados + datos)
        $dataEndRow = $rowIndex - 1;
        $tableRange = "A{$headerRow}:{$lastCol}{$dataEndRow}";
        $sheet->getStyle($tableRange)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)
            ->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF000000'));

        // Centrar columnas específicas, ejemplo D y E (Stock Actual y Stock Mínimo)
        $sheet->getStyle("D" . ($headerRow + 1) . ":E{$dataEndRow}")
            ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Crear writer
        $writer = new Xlsx($spreadsheet);

        // Headers para descarga
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"{$this->filename}\"");
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
