<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProyectoActividadComentariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyecto_actividad_comentarios', function (Blueprint $table) {
            $table->id();
            $table->text('comentario')->nullable();
            $table->unsignedBigInteger('proyecto_actividad_id');
            $table->foreign('proyecto_actividad_id')
                ->references('id')
                ->on('proyecto_actividads')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('proyecto_actividad_comentarios');
    }
}
