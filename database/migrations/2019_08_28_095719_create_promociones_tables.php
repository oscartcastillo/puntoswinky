<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromocionesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promociones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('promocion_nombre', 100);
            $table->string('promocion_codigo', 100);
            $table->string('promocion_tipo', 20);
            $table->integer('promocion_cantidad');
            $table->string('promocion_repetir', 5)->nullable();
            $table->string('promocion_dias', 30)->nullable();
            $table->string('promocion_dias_nombre', 100)->nullable();
            $table->string('promocion_color', 20);
            $table->dateTime('promocion_inicio');
            $table->dateTime('promocion_fin')->nullable();
            $table->string('promocion_estatus');
            $table->integer('user_id')->unsigned()->nullable();
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
        Schema::dropIfExists('promociones');
    }
}
