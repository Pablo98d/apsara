<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_cuentas', function (Blueprint $table) {
            $table->bigIncrements('id_cuenta');
            $table->foreignId('id_usuario', 20);
            $table->string('descripcion_cuenta')->nullable();
            $table->foreignId('id_nivel', 20);
            $table->string('wallet', 100)->nullable();
            $table->string('estatus_cuenta')->nullable();
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
        Schema::dropIfExists('tbl_cuentas');
    }
}
