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
            $table->string('respuesta1', 2);
            $table->string('respuesta2', 2);
            $table->string('respuesta3', 2);
            $table->string('respuesta4', 2);
            $table->string('respuesta5', 2);
            $table->string('respuesta6', 2);
            $table->string('respuesta7', 2);
            $table->string('respuesta8', 2);
            $table->string('respuesta9', 2);
            //$table->string('respuesta10', 200);
            
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('encuestas')->onDelete('cascade');
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
