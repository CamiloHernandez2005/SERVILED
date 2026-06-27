<?php

namespace App\Exports;

use App\Models\Person;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithTitle;


class PeopleExport implements FromCollection, WithHeadings, WithCustomStartCell, WithTitle, WithEvents
{
    use Exportable;

    protected $role;

    public function __construct($role)
    {
        $this->role = $role;
    }

    public function title(): string
    {
        if ($this->role === 'supplier') {
            return 'Proveedores';
        } elseif ($this->role === 'customer') {
            return 'Clientes';
        } else {
            return 'Personas';
        }
    }

    public function headings(): array
    {
        return [
            'Rol',
            'Tipo de Identificación',
            'Identificación',
            'DV',
            'Razón social',
            'Primer nombre',
            'Otro nombre',
            'Apellido',
            'Segundo apellido',
            'Nombre comercial',
            'Correo electrónico',
            'Ciudad',
            'Dirección',
            'Celular',
            'Estado'
        ];
    }

    public function query()
    {
        $query = Person::query()
            ->select('rol', 'identification_type', 'identification_number', 'digit_verification', 'company_name', 'first_name', 'other_name', 'surname', 'second_surname', 'comercial_name', 'email_address', 'municipality_id', 'address', 'phone', 'status');

        if ($this->role === 'supplier') {
            $query->where('rol', 'Proveedor');
        } elseif ($this->role === 'customer') {
            $query->where('rol', 'Cliente');
        } else {
            $query->whereIn('rol', ['proveedor', 'cliente']);
        }

        // Aplicar la transformación para el estado
        return $query->get()->map(function ($person) {
            $person->status = $person->status ? 'Activo' : 'Inactivo';
            return $person;
        });
    }
    public function collection()
    {
        return $this->query();
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

                foreach($sheet->getDelegate()->getRowIterator() as $row){
                    foreach ($row->getCellIterator() as $cell){
                        if($cell->getValue() === 'Activo'){
                            $cell->getStyle()->applyFromArray([
                                'font' => ['color' => ['argb' => 'FF28a745']],
                            ]);
                        }elseif($cell->getValue() === 'Inactivo'){
                            $cell->getStyle()->applyFromArray([
                                'font' => ['color' => ['argb' => 'FFdc3545']],
                            ]);
                        }
                    }
                }
            // Ajustar automáticamente el tamaño de las columnas según su contenido
            foreach ($sheet->getColumnIterator() as $column) {
                $sheet->getDelegate()->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
            }

            // Definir el rango desde A1 hasta L4 para el encabezado
            $headerRange = 'A1:O3';

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

            $sheet->getDelegate()->getStyle('A5:O5')->applyFromArray([
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


            $title = $this->title();
            // Fusionar celdas para el encabezado
            $sheet->getDelegate()->mergeCells('A1:O1');
            $sheet->setCellValue('A1', 'Informe de ' . $title);
            $sheet->getStyle('A1')->getFont()->setSize(20); // Tamaño de letra para "Informe de Ventas"
            $sheet->getStyle('A1')->getFont()->setBold(true); // Ajustar a negrita
            $sheet->getStyle('A1')->getAlignment()->setWrapText(true);
            $sheet->getStyle('A1')->getFont()->getColor()->setARGB(Color::COLOR_WHITE); // Letra blanca

            // Agregar "Ferretería La Excelencia" y "NIT 1.057.599.366" en celdas separadas
            $sheet->getDelegate()->mergeCells('A2:O2');
            $sheet->setCellValue('A2', 'SERVILED');
            $sheet->getStyle('A2')->getFont()->setSize(16); // Tamaño de letra para "Ferretería La Excelencia"
            $sheet->getStyle('A2')->getFont()->setBold(false); // Ajustar a negrita
            $sheet->getStyle('A2')->getAlignment()->setWrapText(true);
            $sheet->getStyle('A2')->getFont()->getColor()->setARGB(Color::COLOR_WHITE); // Letra blanca

            $sheet->getDelegate()->mergeCells('A3:O3');
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
        },
    ];

}


}
