<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVisibleToPresupuestoUnidads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('presupuesto_unidads',function(Blueprint $table){
        $table->integer('visible')->nullable();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('presupuesto_unidads',function(
        Blueprint $table){
          $table->dropColumn('visible');
        });
    }
}
