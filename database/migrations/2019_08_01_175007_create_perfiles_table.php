<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perfiles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('perfil_nombre', 100);
            $table->string('perfil_apellidos', 100);
            $table->string('perfil_tarjeta', 12)->nullable();
            $table->string('perfil_genero', 1);
            $table->date('perfil_nacimiento');
            $table->string('perfil_celular', 12)->nullable();
            $table->string('perfil_compania', 50)->nullable();
            $table->integer('avatar_id')->unsigned()->nullable();
            $table->integer('tipo_perfil_id')->unsigned()->nullable();
            $table->integer('clasificacion_id')->unsigned()->nullable();
            $table->integer('empresa_id')->unsigned()->nullable();
            $table->integer('ciudad_id')->unsigned()->nullable();
            $table->integer('vendedor_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('tipo_perfil_id')->references('id')->on('tipo_perfiles')->onDelete('cascade');
            $table->foreign('clasificacion_id')->references('id')->on('clasificaciones')->onDelete('cascade');
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade');
            $table->foreign('ciudad_id')->references('id')->on('ciudades')->onDelete('cascade');
            $table->foreign('vendedor_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('perfiles');
    }
}
