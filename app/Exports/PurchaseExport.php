<?php

namespace App\Exports;

use App\Models\DetailPurchase;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithTitle;

class PurchaseExport implements FromCollection, WithHeadings, WithCustomStartCell, WithTitle, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function title(): string
    {
        return 'Informe de Compras';
    }

    public function collection()
    {
        return DetailPurchase::with('product:id,name_product')
            ->select([
                'id',
                'date_purchase',
                'total_tax',
                'form_of_payment',
                'gross_total',
                'net_total',
                'discount_total',
                'status',
                'method_of_payment'
            ])
            ->get()
            ->map(function ($sale) {
                $status = $sale->status ? 'Activo' : 'Inactivo';
                return [
                    'id' => $sale->id,
                    'date_purchase' => $sale->date_purchase,
                    'gross_total' => $sale->gross_total,
                    'total_tax' => $sale->total_tax,
                    'discount_total' => $sale->discount_total,
                    'net_total' => $sale->net_total,
                    'form_of_payment' => $sale->form_of_payment,
                    'method_of_payment' => $sale->method_of_payment,
                    'status' => $status
                ];
            });
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'Fecha elaboración',
            'Total Bruto',
            'IVA',
            'Total Descuentos',
            'Total Factura',
            'Forma de Pago',
            'Metodo de Pago',
            'Estado'
        ];
    }

    public function startCell(): string
    {
        return 'A5';
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;

                // Insertar la imagen en una celda específica
                $imagePath = public_path('img/logo.png');
                $drawing = new Drawing();
                $drawing->setName('Logo');
                $drawing->setDescription('Logo');
                $drawing->setPath($imagePath);
                $drawing->setHeight(55); // Ajusta la altura de la imagen según tu preferencia
                $drawing->setCoordinates('A1'); // Celda donde se insertará la imagen
                $drawing->setWorksheet($sheet->getDelegate());

            // Ajustar automáticamente el tamaño de las columnas según su contenido
            foreach ($sheet->getColumnIterator() as $column) {
                $sheet->getDelegate()->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
            }

            // Definir el rango desde A1 hasta L4 para el encabezado
            $headerRange = 'A1:I3';

            // Aplicar color azul al encabezado
            $sheet->getDelegate()->getStyle($headerRange)->applyFromArray([
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => '0B2742'], // Azul
                ],
                'font' => [
                    'name' => 'Oswald', // Tipo de letra Oswald
                    'color' => ['rgb' => 'FFFFFF'], // Letra blanca
                    'bold' => true,
                    'size' => 16,
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'bottom' => [
                        'borderStyle' => Border::BORDER_THICK,
                        'color' => ['argb' => 'F5B50A'],
                    ],
                ],
            ]);

            $sheet->getDelegate()->getStyle('A5:I5')->applyFromArray([
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'd3d3d3'], // Gris claro
                ],
                'font' => [
                    'bold' => true,
                ],
            ]);

            $sheet->getDelegate()->getStyle('A1:' . $sheet->getDelegate()->getHighestColumn() . $sheet->getDelegate()->getHighestRow())->applyFromArray([
                'font' => [
                    'name' => 'Oswald', // Tipo de letra Oswald
                ],
            ]);

            

            // Fusionar celdas para el encabezado
            $sheet->getDelegate()->mergeCells('A1:I1');
            $sheet->setCellValue('A1', 'Informe de Compras');
            $sheet->getStyle('A1')->getFont()->setSize(20); // Tamaño de letra para "Informe de Ventas"
            $sheet->getStyle('A1')->getFont()->setBold(true); // Ajustar a negrita
            $sheet->getStyle('A1')->getAlignment()->setWrapText(true);
            $sheet->getStyle('A1')->getFont()->getColor()->setARGB(Color::COLOR_WHITE); // Letra blanca

            // Agregar "Ferretería La Excelencia" y "NIT 1.057.599.366" en celdas separadas
            $sheet->getDelegate()->mergeCells('A2:I2');
            $sheet->setCellValue('A2', 'SERVILED');
            $sheet->getStyle('A2')->getFont()->setSize(16); // Tamaño de letra para "Ferretería La Excelencia"
            $sheet->getStyle('A2')->getFont()->setBold(false); // Ajustar a negrita
            $sheet->getStyle('A2')->getAlignment()->setWrapText(true);
            $sheet->getStyle('A2')->getFont()->getColor()->setARGB(Color::COLOR_WHITE); // Letra blanca

            $sheet->getDelegate()->mergeCells('A3:I3');
            $sheet->setCellValue('A3', 'NIT ' . config('company.nit'));
            $sheet->getStyle('A3')->getFont()->setSize(14); // Tamaño de letra para "NIT 1.057.599.366"
            $sheet->getStyle('A3')->getFont()->setBold(false); // Ajustar a negrita
            $sheet->getStyle('A3')->getAlignment()->setWrapText(true);
            $sheet->getStyle('A3')->getFont()->getColor()->setARGB(Color::COLOR_WHITE); // Letra blanca

            // Aplicar bordes a las celdas de la tabla
            $tableRange = 'A5:' . $sheet->getHighestColumn() . $sheet->getHighestRow();
            $sheet->getDelegate()->getStyle($tableRange)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => '00000000'],
                    ],
                ],
            ]);

            // Formato de miles para las columnas de dinero
            $sheet->getDelegate()->getStyle('C6:F' . $sheet->getDelegate()->getHighestRow())
                  ->getNumberFormat()->setFormatCode('#,##0');
        },
    ];
}
}