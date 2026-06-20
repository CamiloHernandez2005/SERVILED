<?php

namespace App\Imports;

use App\Models\MeasurementUnit;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class UnitsImpot implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, WithUpserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new MeasurementUnit([
            'code' => $row['codigo'],
            'name' => $row['nombre_unidad'],
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
        return 'name';
        return 'code';
    }
}
