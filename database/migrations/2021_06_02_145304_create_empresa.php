<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpresa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('empresas', function (Blueprint $table) {
      $table->increments('id');
      $table->string('nombreemp');
      $table->string('repnombre');
      $table->integer('telefono');
      $table->string('diremp');
      $table->string('rubro');
      $table->integer('nit');
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
        Schema::dropIfExists('empresas');
    }
}
