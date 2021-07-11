<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacultadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('facultad', function (Blueprint $table) {
          $table->increments('id');
          $table->string('nombre');
          $table->string('decano');
          $table->string('telefono');
          $table->string('direccion');
          $table->string('correo');
          $table->integer('visible');
          // $table->integer('user_id')->unsigned();
          $table->timestamps();

          // $table->foreign('user_id')->references('id')->on('users');
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
