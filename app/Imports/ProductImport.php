<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class ProductImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, WithUpserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
            'name_product' => $row['nombre_producto'],
            'description_long' => $row['descripcion_producto'],
            'factory_reference' => $row['referencia_fabrica'],
            'classification_tax' => $row['clasificacion_tributaria'],
            'selling_price' => $row['precio_venta'],
            'subcategory_product' => $row['nombre_subcategoria'],
            'category_products_id' => $row['id_categoria'],
            'brands_id' => $row['id_marca'],
            'measurement_units_id' => $row['id_unidad_medida'],
        ]);
    }

    public function batchSize(): int
    {
        return 2000;
    }

    public function chunkSize(): int
    {
        return 2000;
    }

    public function uniqueBy()
    {
        return 'name_product';
        return 'factory_reference';
    }
}
