<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnidadAsignacionesitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unidadasignacionitems', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('unidad_id')->unsigned();
            $table->integer('itemsuperior_id')->unsigned();
            $table->decimal('montoasig',9,2);
            $table->string('periodo');                
            $table->timestamps();

            //References
            $table->foreign('unidad_id')->references('id')->on('unidads');
            $table->foreign('itemsuperior_id')->references('id')->on('item_superiors')->onDelete('cascade');
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
