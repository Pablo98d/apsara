<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInversionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_inversiones', function (Blueprint $table) {
            $table->bigIncrements('id_inversion');
            $table->foreignId('id_cuenta', 20); 
            $table->string('descripcion', 20);
            $table->string('tipopago', 20);
            $table->string('origen', 20);
            $table->double('total', 10, 2);
            $table->string('estatus', 20);
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
        Schema::dropIfExists('tbl_inversiones');
    }
}
