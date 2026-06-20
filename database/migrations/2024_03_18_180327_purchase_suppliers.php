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
        Schema::create('purchase_suppliers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('invoice_number_purchase');
            $table->date('date_invoice_purchase');
           //$table->string('code');
            $table->integer('users_id');
            $table->boolean('status')->default(True);
            $table->integer('people_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_suppliers');
    }
};
