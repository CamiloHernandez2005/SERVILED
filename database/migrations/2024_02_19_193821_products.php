<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Products extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function(Blueprint $table){
            $table->engine="InnoDB";
            $table->bigIncrements('id');
            $table->string('name_product')->unique();
            $table->string('description_long')->nullable();
            $table->string('factory_reference')->unique();
            $table->string('classification_tax');
            $table->decimal('selling_price',10,2);
            $table->decimal('purchase_price',10,2)->default(0);
            $table->string('photo')->nullable();
            $table->boolean('status')->default(True);
            $table->string('stock')->default(0);
            $table->string('subcategory_product');
            $table->bigInteger('category_products_id')->unsigned();
            $table->bigInteger('brands_id')->unsigned();
            $table->bigInteger('measurement_units_id')->unsigned();
            $table->timestamps();
            $table->foreign('category_products_id')->references('id')->on('category_products')->onDelete("no action");
            $table->foreign('brands_id')->references('id')->on('brands')->onDelete("no action");
            $table->foreign('measurement_units_id')->references('id')->on('measurement_units')->onDelete("no action");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
