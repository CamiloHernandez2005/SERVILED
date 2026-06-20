<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Columnas que estaban en decimal(8,2) (máx 999.999,99) y se desbordan
     * con montos grandes. Se amplían a decimal(15,2).
     */
    private array $columnas = [
        'sales'                     => ['gross_totals', 'taxes_total', 'total_discounts', 'net_total'],
        'credit_note_sales'         => ['gross_totals', 'taxes_total', 'total_discounts', 'net_total'],
        'credit_note_sales_product' => ['selling_price', 'discounts', 'tax', 'iva'],
        'product_sale'              => ['selling_price', 'discounts', 'tax', 'iva'],
        'debit_note_suppliers'      => ['total'],
    ];

    public function up(): void
    {
        foreach ($this->columnas as $tabla => $cols) {
            foreach ($cols as $col) {
                DB::statement("ALTER TABLE `{$tabla}` MODIFY `{$col}` DECIMAL(15,2) NOT NULL");
            }
        }
    }

    public function down(): void
    {
        foreach ($this->columnas as $tabla => $cols) {
            foreach ($cols as $col) {
                DB::statement("ALTER TABLE `{$tabla}` MODIFY `{$col}` DECIMAL(8,2) NOT NULL");
            }
        }
    }
};
