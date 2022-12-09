<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_servicios', function (Blueprint $table) {
            $table->bigIncrements('id_servicio');
            $table->string('servicio');
            $table->string('descripcion');
            $table->double('inversion', 10, 2);
            $table->double('ganancia', 10, 2);
            $table->integer('puntos');
            $table->string('estatus',50);
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
        Schema::dropIfExists('tbl_servicios');
    }
}
