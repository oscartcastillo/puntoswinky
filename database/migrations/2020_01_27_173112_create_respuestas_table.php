<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRespuestasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respuestas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('respuesta1');
            $table->integer('respuesta2');
            $table->integer('respuesta3');
            $table->integer('respuesta4');
            $table->integer('respuesta5');
            $table->integer('respuesta6');
            $table->integer('respuesta7');
            $table->integer('respuesta8');
            $table->integer('respuesta9');
            $table->string('respuesta10', 500);
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
        Schema::dropIfExists('respuestas');
    }
}
