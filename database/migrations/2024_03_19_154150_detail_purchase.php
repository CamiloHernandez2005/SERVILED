<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
    {
        Schema::create('detail_purchase', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('note', 500)->nullable();
        $table->string('description', 500)->nullable();
        $table->decimal('price_unit', 20, 2);
        $table->decimal('product_tax', 20, 2);
        $table->double('quantity_units');
        $table->date('date_purchase');
        $table->string('form_of_payment', 45);
        $table->decimal('gross_total', 20, 2);
        $table->decimal('total_tax', 20, 2);
        $table->decimal('net_total', 20, 2);
        $table->decimal('total_value', 20, 2);
        $table->decimal('discount_total', 20, 2);
        $table->boolean('status')->default(True);
        $table->string('method_of_payment',200);
        $table->unsignedInteger('purchase_suppliers_id'); 
        $table->unsignedBigInteger('products_id');
        $table->timestamps();

        $table->foreign('purchase_suppliers_id')->references('id')->on('purchase_suppliers')->onDelete('cascade');
        $table->foreign('products_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_purchase');
    }
    };