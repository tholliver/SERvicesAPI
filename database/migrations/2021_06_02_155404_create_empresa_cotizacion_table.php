<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpresaCotizacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresa_cotizacion', function (Blueprint $table) {
            $table->increments('id');            
            
            //New addts
            $table->string('observaciones'); 
            $table->string('plazo_de_entrega');      
            $table->string('validez_oferta');       
            $table->decimal('total',9,2);
            $table->binary('cotizacion_pdf'); 
            $table->string('eleccion'); 
            //

            $table->timestamps();
            $table->integer('id_empresa')->unsigned(); 
            $table->integer('id_solicitud')->unsigned();
            
            //References
            $table->foreign('id_empresa')->references('id')->on('empresas')->onDelete('cascade');
            $table->foreign('id_solicitud')->references('id')->on('solicituds')->onDelete('cascade');
            
        });
    }

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