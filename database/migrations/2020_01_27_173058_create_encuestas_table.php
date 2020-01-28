<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEncuestasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('encuestas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 200);
            $table->string('email')->unique();
            $table->string('edad', 2);
            $table->string('sexo', 2);
            $table->integer('medio_difucion');
            $table->integer('tipo_perfil_id')->unsigned()->nullable();
            $table->integer('empresa_id')->unsigned()->nullable();
            
            $table->foreign('tipo_perfil_id')->references('id')->on('tipo_perfiles')->onDelete('cascade');
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade');
            
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
        Schema::dropIfExists('encuestas');
    }
}
