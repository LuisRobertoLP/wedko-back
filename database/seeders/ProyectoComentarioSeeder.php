<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProyectoComentario;

class ProyectoComentarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->insert('comentario de antonio',1,1);
        $this->insert('comentario de edgar',2,1);
        $this->insert('comentario de oscar',3,1);
        $this->insert('comentario de wuicho',4,1);
        $this->insert('comentario de daniela',5,1);
        $this->insert('comentario de klithiel',6,1);

    }
    private function insert(
        $comentario,
        $usuario_id,
        $proyecto_id
    ){
        $proyectoComentario = new ProyectoComentario();
        $proyectoComentario->comentario = $comentario;
        $proyectoComentario->usuario_id = $usuario_id;
        $proyectoComentario->proyecto_id = $proyecto_id;
        $proyectoComentario->created_at = now();
        $proyectoComentario->updated_at = now();
        $proyectoComentario->save();
    }
}
