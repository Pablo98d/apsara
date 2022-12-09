<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquiposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_equipos', function (Blueprint $table) {
            $table->bigIncrements('id_equipos');
            $table->foreignId('id_nivel', 20);
            $table->foreignId('id_usuario', 20);
            $table->foreignId('id_patrocinador', 20);
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
        Schema::dropIfExists('tbl_equipos');
    }
}
