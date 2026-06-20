<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\MeasurementUnit;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            RoleSeeder::class,
            UnitsTableSeeder::class,
            CountriesSeeder::class,
            DepartmentsSeeder::class,
            MunicipalitiesSeeder::class
            
        ]);
    }
}
