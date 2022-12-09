<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_productos', function (Blueprint $table) {
            $table->bigIncrements('id_producto');
            $table->string('producto');
            $table->string('descripcion');
            $table->double('inversion', 10, 2);
            $table->double('ganancia', 10, 2);
            $table->integer('puntos');
            $table->string('estatus',50);
            $table->string('img',50);
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
        Schema::dropIfExists('tbl_productos');
    }
}
