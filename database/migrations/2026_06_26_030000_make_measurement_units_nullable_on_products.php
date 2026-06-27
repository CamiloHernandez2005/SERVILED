<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * La unidad de medida del producto pasa a ser opcional.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE `products` MODIFY `measurement_units_id` BIGINT UNSIGNED NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE `products` MODIFY `measurement_units_id` BIGINT UNSIGNED NOT NULL");
    }
};
