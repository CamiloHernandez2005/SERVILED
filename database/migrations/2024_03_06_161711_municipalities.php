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
        Schema::create('municipalities', function (Blueprint $table) {
        $table->engine="InnoDB";
        $table->bigIncrements('id');
        $table->string('code');
        $table->string('name');
        $table->bigInteger('departments_id')->unsigned();
        $table->timestamps();
        $table->foreign('departments_id')->references('id')->on('departments')->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('municipalities');
    }
};
