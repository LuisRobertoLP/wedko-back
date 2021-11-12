<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EstatusProyecto;

class EstatusProyectoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->insert('En proceso','El proyecto esta en desarrollo');
        $this->insert('Finalizado','El proyecto ha finalizado');
        $this->insert('Cancelada','El proyecto se ha cancelado');
    }
    private function insert($nombre,$descripcion){
        $estatusProyecto = new EstatusProyecto();
        $estatusProyecto->nombre = $nombre;
        $estatusProyecto->descripcion = $descripcion;
        $estatusProyecto->created_at = now();
        $estatusProyecto->updated_at = now();
        $estatusProyecto->save();
    }
}
