<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePremiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('premios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('premio_nombre', 100);
            $table->string('premio_descripcion', 200);
            $table->string('premio_imagen', 200);
            $table->integer('premio_precio');
            $table->integer('premio_stock');
            $table->string('premio_estatus', 10);

            $table->integer('empresa_id')->unsigned()->nullable();
            $table->integer('clasificacion_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned()->nullable();

            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade');
            $table->foreign('clasificacion_id')->references('id')->on('clasificaciones')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('premios');
    }
}
