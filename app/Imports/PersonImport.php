<?php

namespace App\Imports;

use App\Models\Person;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class PersonImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading,  WithUpserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Person([
            'rol' => $row['tercero'],
            'identification_type'=>  $row['tipo_de_identificacion'],
            'identification_number' => $row['numero_de_identificacion'],
            'digit_verification'=>  $row['digito_de_verificacion'],
            'person_type' => $row['tipo_de_persona'],            
            'company_name '=> $row['razon_social'],
            'comercial_name' => $row['nombre_comercial'],
            'first_name'=> $row['primer_nombre'],
            'other_name'=> $row['otro_nombre'],
            'surname'=> $row['apellido'],
            'second_surname'=> $row['segundo_apellido'],
            'comercial_name'=> $row['nombre_comercial'],
            'email_address'=> $row['correo_electronico'],
            'municipality_id'=> $row['ciudad'],
            'address'=> $row['direccion'],
            'phone'=> $row['celular'],
            'status' => true,
        ]);
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function uniqueBy()
    {
        return 'identification_number';
    }
    
}
