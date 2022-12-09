<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_pagos', function (Blueprint $table) {
            $table->bigIncrements('id_pago');
            $table->foreignId('id_cuenta', 20);
            $table->string('descripcion')->nullable();
            $table->string('metodo_pago')->nullable();
            $table->string('direccion')->nullable();
            $table->string('cantidad', 50)->nullable();
            $table->string('comision')->nullable();
            $table->string('total')->nullable();
            $table->string('hash')->nullable();
            $table->string('estatus')->nullable();
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
        Schema::dropIfExists('tbl_pagos');
    }
}
