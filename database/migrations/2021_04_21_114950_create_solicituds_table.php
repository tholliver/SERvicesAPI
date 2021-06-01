<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicituds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('unidad_id')->unsigned(); //ADDED
            $table->string('unidad_nombre');    //ADDED
            $table->string('tipo'); 
            $table->string('responsable');            
            $table->decimal('montoestimado',9,3);
            $table->string('estado');
            $table->string('supera');
            $table->timestamps();

            $table->foreign('unidad_id')->references('id')->on('unidads'); //added
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solicituds');
    }
}
