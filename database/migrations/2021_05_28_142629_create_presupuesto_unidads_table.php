<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePresupuestoUnidadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presupuesto_unidads', function (Blueprint $table) {
            $table->increments('id');                     
            $table->integer('id_unidad')->unsigned();
            $table->decimal('presupuesto',9,2);
            $table->string('gestion');   
            $table->timestamps();   
            
            //References
            $table->foreign('id_unidad')->references('id')->on('unidads')->onDelete('cascade');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('presupuesto_unidads');
    }
}
