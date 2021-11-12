<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Proyecto;

class ProyectoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->insert('proyecto wedko','descripción',1);

    }
    private function insert($nombre,$descripcion,$estatus_proyecto_id){
        $proyecto = new Proyecto();
        $proyecto->nombre = $nombre;
        $proyecto->descripcion = $descripcion;
        $proyecto->estatus_proyecto_id = $estatus_proyecto_id;
        $proyecto->created_at = now();
        $proyecto->updated_at = now();
        $proyecto->save();
    }
}
