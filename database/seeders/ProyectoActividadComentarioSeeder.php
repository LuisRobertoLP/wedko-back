<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProyectoActividadComentario;

class ProyectoActividadComentarioSeeder extends Seeder
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

        $this->insert('comentario de edgar 1.0',2,2);
        $this->insert('comentario de oscar 1.0',3,2);
        $this->insert('comentario de wuicho 1.0',4,2);

        $this->insert('comentario de edgar 1.1',2,3);
        $this->insert('comentario de oscar 1.1',3,3);
        $this->insert('comentario de wuicho 1.1',4,3);
        
        $this->insert('comentario de edgar 1.2',2,4);
        $this->insert('comentario de oscar 1.2',3,4);
        $this->insert('comentario de wuicho 1.2',4,4);

        $this->insert('comentario de daniela 1.0',2,5);
        $this->insert('comentario de klithiel 1.0',3,5);
        
        $this->insert('comentario de daniela 1.1',2,6);
        $this->insert('comentario de klithiel 1.1',3,6);

        $this->insert('comentario de daniela 1.2',2,7);
        $this->insert('comentario de klithiel 1.2',3,7);
    }
    private function insert(
        $comentario,
        $usuario_id,
        $proyecto_actividad_id
    ){
        $proyectoActividadComentario = new ProyectoActividadComentario();
        $proyectoActividadComentario->comentario = $comentario;
        $proyectoActividadComentario->usuario_id = $usuario_id;
        $proyectoActividadComentario->proyecto_actividad_id = $proyecto_actividad_id;
        $proyectoActividadComentario->created_at = now();
        $proyectoActividadComentario->updated_at = now();
        $proyectoActividadComentario->save();
    }
}
