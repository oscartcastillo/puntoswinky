<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBonosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bonos', function (Blueprint $table) {
            $table->increments('id');
            $table->date('bono_inicio');
            $table->date('bono_fin');
            
            $table->integer('tipo_bono_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('vendedor_id')->unsigned();
            $table->integer('empresa_id')->unsigned();
            $table->string('bono_estatus', 10);
            
            $table->foreign('tipo_bono_id')->references('id')->on('tipo_bonos')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('vendedor_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('bonos');
    }
}
