<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('debit_note_suppliers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('debit_note_code');
            $table->date('date_invoice');
            $table->unsignedBigInteger('detail_purchase_id'); 
            $table->unsignedBigInteger('users_id');
            $table->unsignedInteger('purchase_suppliers_id'); 
           // $table->decimal('price'); 
            $table->integer('quantity'); 
            $table->string('description'); 
            $table->decimal('total'); 
            $table->decimal('net_total', 20, 2);
            $table->decimal('gross_total', 20, 2);
            $table->string('motive');
            $table->timestamps();
            $table->boolean('status')->default(True);
            $table->foreign('detail_purchase_id')->references('id')->on('detail_purchase')->onDelete('cascade');
            $table->foreign('users_id')->references('id')->on('users');
            $table->foreign('purchase_suppliers_id')->references('id')->on('purchase_suppliers')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('debit_note_suppliers');
    }
};
