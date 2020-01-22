<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransaccionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transacciones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('transaccion_ticket')->nullable()->unique();
            $table->date('transaccion_fecha')->nullable();
            $table->decimal('transaccion_cantidad', 6, 2);
            $table->string('transaccion_puntos_extras', 20)->nullable();
            $table->string('transaccion_descripcion', 300)->nullable();
            $table->decimal('transaccion_abono', 6, 2);
            $table->string('transaccion_tipo', 20);

            $table->string('transaccion_estatus', 20);
            
            $table->integer('premio_id')->unsigned()->nullable();
            $table->integer('promocion_id')->unsigned()->nullable();
            $table->integer('empresa_id')->unsigned()->nullable();
            $table->integer('vendedor_id')->unsigned()->nullable();

            $table->string('cancelacion_descripcion', 200)->nullable();
            $table->integer('cancelacion_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            
            $table->foreign('premio_id')->references('id')->on('premios')->onDelete('cascade');
            $table->foreign('promocion_id')->references('id')->on('promociones')->onDelete('cascade');
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade');
            $table->foreign('vendedor_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('cancelacion_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('transacciones');
    }
}
