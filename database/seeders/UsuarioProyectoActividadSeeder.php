<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UsuarioProyectoActividad;

class UsuarioProyectoActividadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->insert(2,2);
        $this->insert(3,2);
        $this->insert(4,2);

        $this->insert(2,3);
        $this->insert(3,3);
        $this->insert(4,3);

        $this->insert(2,4);
        $this->insert(3,4);
        $this->insert(4,4);

        $this->insert(5,5);
        $this->insert(6,5);
        
        $this->insert(5,6);
        $this->insert(6,6);

        $this->insert(5,7);
        $this->insert(6,7);

    }

    private function insert(
        $usuario_id,
        $proyecto_actividad_id
    ){
        $usuarioProyectoActividad = new UsuarioProyectoActividad();
        $usuarioProyectoActividad->usuario_id = $usuario_id;
        $usuarioProyectoActividad->proyecto_actividad_id = $proyecto_actividad_id;
        $usuarioProyectoActividad->created_at = now();
        $usuarioProyectoActividad->updated_at = now();
        $usuarioProyectoActividad->save();
    }
}
