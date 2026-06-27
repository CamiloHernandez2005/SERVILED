<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Elimina por completo la funcionalidad de categorias y subcategorias:
     * quita las columnas de la tabla products y elimina las tablas
     * sub_categories y category_products.
     */
    public function up(): void
    {
        if (Schema::hasColumn('products', 'category_products_id')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropForeign(['category_products_id']);
                $table->dropColumn('category_products_id');
            });
        }

        if (Schema::hasColumn('products', 'subcategory_product')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('subcategory_product');
            });
        }

        // sub_categories tiene FK hacia category_products, se elimina primero.
        Schema::dropIfExists('sub_categories');
        Schema::dropIfExists('category_products');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('category_products', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('description')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::create('sub_categories', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('description')->nullable();
            $table->boolean('status')->default(true);
            $table->bigInteger('category_id')->unsigned();
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('category_products');
        });

        if (!Schema::hasColumn('products', 'subcategory_product')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('subcategory_product')->nullable();
            });
        }

        if (!Schema::hasColumn('products', 'category_products_id')) {
            Schema::table('products', function (Blueprint $table) {
                $table->bigInteger('category_products_id')->unsigned()->nullable();
                $table->foreign('category_products_id')->references('id')->on('category_products')->onDelete("no action");
            });
        }
    }
};
