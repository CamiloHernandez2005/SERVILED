<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Agrega el campo de ganancias:
     *  - product_sale: purchase_price (costo en el momento de la venta) y profit (ganancia de la linea).
     *  - sales: total_profit (suma de las ganancias de las lineas).
     *
     * Ganancia por linea = (selling_price * amount) - discounts - (purchase_price * amount)
     */
    public function up(): void
    {
        Schema::table('product_sale', function (Blueprint $table) {
            if (!Schema::hasColumn('product_sale', 'purchase_price')) {
                $table->decimal('purchase_price', 15, 2)->default(0)->after('selling_price');
            }
            if (!Schema::hasColumn('product_sale', 'profit')) {
                $table->decimal('profit', 15, 2)->default(0)->after('iva');
            }
        });

        Schema::table('sales', function (Blueprint $table) {
            if (!Schema::hasColumn('sales', 'total_profit')) {
                $table->decimal('total_profit', 15, 2)->default(0)->after('net_total');
            }
        });

        // Backfill: usa el precio de compra actual del producto como mejor estimacion
        // del costo de las ventas ya registradas.
        DB::statement("
            UPDATE product_sale ps
            JOIN products p ON p.id = ps.product_id
            SET ps.purchase_price = p.purchase_price,
                ps.profit = (ps.selling_price * ps.amount) - ps.discounts - (p.purchase_price * ps.amount)
        ");

        DB::statement("
            UPDATE sales s
            SET s.total_profit = (
                SELECT COALESCE(SUM(ps.profit), 0)
                FROM product_sale ps
                WHERE ps.sale_id = s.id
            )
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_sale', function (Blueprint $table) {
            if (Schema::hasColumn('product_sale', 'purchase_price')) {
                $table->dropColumn('purchase_price');
            }
            if (Schema::hasColumn('product_sale', 'profit')) {
                $table->dropColumn('profit');
            }
        });

        Schema::table('sales', function (Blueprint $table) {
            if (Schema::hasColumn('sales', 'total_profit')) {
                $table->dropColumn('total_profit');
            }
        });
    }
};
