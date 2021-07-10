<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemSolicitudTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_solicitud', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('item_id')->unsigned();
            $table->integer('solicitud_id')->unsigned();   
            
            //New addts
            $table->string('nombre'); 
            $table->string('descrip');      
            $table->integer('cantidad');       
            $table->decimal('precio',9,2);
            
            //

            $table->timestamps();

            //References
            $table->foreign('item_id')->references('id')->on('items');
            $table->foreign('solicitud_id')->references('id')->on('solicituds')->onDelete('cascade');
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