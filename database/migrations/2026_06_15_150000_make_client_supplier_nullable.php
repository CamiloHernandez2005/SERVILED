<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    // Cliente (ventas) y proveedor (compras) ahora son opcionales.
    public function up(): void
    {
        DB::statement("ALTER TABLE `sales` MODIFY `clients_id` BIGINT UNSIGNED NULL");
        DB::statement("ALTER TABLE `purchase_suppliers` MODIFY `people_id` INT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE `sales` MODIFY `clients_id` BIGINT UNSIGNED NOT NULL");
        DB::statement("ALTER TABLE `purchase_suppliers` MODIFY `people_id` INT NOT NULL");
    }
};
