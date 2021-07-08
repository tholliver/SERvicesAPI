<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCotizacionItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotizacion_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('descripcion');
            $table->integer('cantidad');
            $table->double('precioUnitario');
            $table->double('total');
            
            // $table->integer('empresa_cotizacion_id')->unsigned();
            $table->integer('empresa_cotizacion_id')->unsigned();
            $table->foreign('empresa_cotizacion_id')->references('id')->on('empresa_cotizacion')->onDelete('cascade');
            $table->timestamps();
            
            
        });
    }
// dnJVDe5dtY
//remotemysql.com
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
