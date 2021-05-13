<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('cellphone');
            $table->string('rol');
            $table->string('unidaddegasto',100)->nullable();
            $table->string('facultad',100)->nullable();
            $table->integer('unidad_id')->nullable()->unsigned(); 
            $table->foreign('unidad_id')->references('id')->on('unidads');           
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
