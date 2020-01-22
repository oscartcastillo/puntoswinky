<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBonoDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bono_detalles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tiempo_id')->unsigned()->nullable();
            $table->integer('empresa_id')->unsigned()->nullable();
            $table->integer('vendedor_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('bono_id')->unsigned()->nullable();
            $table->string('detalle_bono_estatus', 10);

            $table->foreign('tiempo_id')->references('id')->on('tiempos')->onDelete('cascade');
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade');
            $table->foreign('vendedor_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('bono_id')->references('id')->on('bonos')->onDelete('cascade');
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
        Schema::dropIfExists('bono_detalles');
    }
}
