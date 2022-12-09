<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGananciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_ganancias', function (Blueprint $table) {
            $table->bigIncrements('id_ganancia');
            $table->foreignId('id_cuenta', 20);
            $table->string('tipo')->nullable();
            $table->string('origen', 50)->nullable();
            $table->string('total')->nullable();
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
        Schema::dropIfExists('tbl_ganancias');
    }
}
