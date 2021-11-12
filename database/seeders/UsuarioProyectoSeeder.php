<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UsuarioProyecto;

class UsuarioProyectoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->insert(1,1,1);
        $this->insert(1,2,2);
        $this->insert(1,3,2);
        $this->insert(1,4,2);
        $this->insert(1,5,3);
        $this->insert(1,6,3);

    }

    private function insert(
        $proyecto_id,
        $usuario_id,
        $role_proyecto_id
    ){
        $usuarioProyecto = new UsuarioProyecto();
        $usuarioProyecto->proyecto_id = $proyecto_id;
        $usuarioProyecto->usuario_id = $usuario_id;
        $usuarioProyecto->role_proyecto_id = $role_proyecto_id;
        $usuarioProyecto->created_at = now();
        $usuarioProyecto->updated_at = now();
        $usuarioProyecto->save();
    }
}
