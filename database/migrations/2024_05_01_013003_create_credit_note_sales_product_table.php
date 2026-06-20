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
        Schema::create('credit_note_sales_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('credit_note_sales_id')->constrained('credit_note_sales')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->integer('amount');
            $table->string('references');
            $table->decimal('selling_price');
            $table->decimal('discounts');   
            $table->decimal('tax');  
            $table->decimal('iva');  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_note_sales_product');
    }
};
