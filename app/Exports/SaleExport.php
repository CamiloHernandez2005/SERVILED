<?php

namespace App\Exports;

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
use App\Models\Sale;

class SaleExport implements FromCollection, WithHeadings, WithCustomStartCell, WithTitle, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function title(): string
    {
        return 'Informe de Ventas';
    }

    public function collection()
    {
        return Sale::with(['cliente:id,identification_number,first_name,other_name,surname,second_surname,company_name'])
            ->select([
                'id',
                'dates',
                'bill_numbers',
                'sellers',
                'payments_methods',
                'gross_totals',
                'taxes_total',
                'total_discounts',
                'net_total',
                'total_profit',
                'status',
                'clients_id'
            ])
            ->get()
            ->map(function ($sale) {
                $fullName = trim("{$sale->cliente?->identification_number} - {$sale->cliente?->first_name} {$sale->cliente?->other_name} {$sale->cliente?->surname} {$sale->cliente?->second_surname} {$sale->cliente?->company_name}");
                $status = $sale->status ? 'Activo' : 'Inactivo';
                return [
                    'id' => $sale->id,
                    'bill_numbers' => $sale->bill_numbers,
                    'dates' => $sale->dates,
                    'client_name' => $fullName,
                    'gross_totals' => $sale->gross_totals,
                    'taxes_total' => $sale->taxes_total,
                    'total_discounts' => $sale->total_discounts,
                    'net_total' => $sale->net_total,
                    'total_profit' => $sale->total_profit,
                    'sellers' => $sale->sellers,
                    'payments_methods' => $sale->payments_methods,
                    'status' => $status
                    
                ];
            });
    }

    public function headings(): array
    {
        return [
            'No',
            'Comprobante',
            'Fecha elaboración',
            'Cliente',
            'Total Bruto',
            'IVA',
            'Total Descuentos',
            'Total Factura',
            'Ganancias',
            'Vendedor',
            'Forma de Pago',
            'Estado'
        ];
    }

    /**
     * @return string
     */
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
            $headerRange = 'A1:L3';

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

            $sheet->getDelegate()->getStyle('A5:L5')->applyFromArray([
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
            $sheet->getDelegate()->mergeCells('A1:L1');
            $sheet->setCellValue('A1', 'Informe de Ventas');
            $sheet->getStyle('A1')->getFont()->setSize(20); // Tamaño de letra para "Informe de Ventas"
            $sheet->getStyle('A1')->getFont()->setBold(true); // Ajustar a negrita
            $sheet->getStyle('A1')->getAlignment()->setWrapText(true);
            $sheet->getStyle('A1')->getFont()->getColor()->setARGB(Color::COLOR_WHITE); // Letra blanca

            // Agregar "Ferretería La Excelencia" y "NIT 1.057.599.366" en celdas separadas
            $sheet->getDelegate()->mergeCells('A2:L2');
            $sheet->setCellValue('A2', 'SERVILED');
            $sheet->getStyle('A2')->getFont()->setSize(16); // Tamaño de letra para "Ferretería La Excelencia"
            $sheet->getStyle('A2')->getFont()->setBold(false); // Ajustar a negrita
            $sheet->getStyle('A2')->getAlignment()->setWrapText(true);
            $sheet->getStyle('A2')->getFont()->getColor()->setARGB(Color::COLOR_WHITE); // Letra blanca

            $sheet->getDelegate()->mergeCells('A3:L3');
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
            $sheet->getDelegate()->getStyle('E6:I' . $sheet->getDelegate()->getHighestRow())
                  ->getNumberFormat()->setFormatCode('#,##0');
        },
    ];
}
}