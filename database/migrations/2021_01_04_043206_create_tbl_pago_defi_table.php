<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblPagoDefiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_pago_defi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_inversion_accion');
            $table->string('descripcion_pago', 100);
            $table->string('cantidad_defi', 10);
            $table->string('metodo_pago', 50);
            $table->double('total_pago', 10, 2);
            $table->string('estatus_pago', 20);
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
        Schema::dropIfExists('tbl_pago_defi');
    }
}
