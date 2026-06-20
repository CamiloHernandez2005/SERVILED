<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('credit_note_sales', function (Blueprint $table) {
            $table->id();
            $table->date('date_invoice');
            $table->string('sellers');
            $table->string('payments_methods');
            $table->decimal('gross_totals');
            $table->decimal('taxes_total');
            $table->decimal('total_discounts');
            $table->decimal('net_total');
            $table->date('date_credit_notes');
            $table->string('reason');
            $table->boolean('status')->default(true);
            $table->bigInteger('clients_id')->unsigned();
            $table->bigInteger('sale_id')->unsigned();
            $table->foreign('clients_id')->references('id')->on('people')->onDelete("no action");
            $table->foreign('sale_id')->references('id')->on('sales')->onDelete("no action");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_note_sales');
    }
};
