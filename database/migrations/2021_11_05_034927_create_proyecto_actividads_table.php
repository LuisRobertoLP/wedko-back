<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProyectoActividadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyecto_actividads', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->nullable();
            $table->text('descripcion')->nullable();
            $table->datetime('fecha')->nullable();
            $table->unsignedBigInteger('proyecto_id');
            $table->foreign('proyecto_id')
                ->references('id')
                ->on('proyectos')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('estatus_proyecto_actividad_id');
            $table->foreign('estatus_proyecto_actividad_id')
                ->references('id')
                ->on('estatus_proyecto_actividads')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->softDeletes();
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
        Schema::dropIfExists('proyecto_actividads');
    }
}
