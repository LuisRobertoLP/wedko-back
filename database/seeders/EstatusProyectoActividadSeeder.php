<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EstatusProyectoActividad;

class EstatusProyectoActividadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->insert('Sin asignar','No se ha asignado responsable');
        $this->insert('En proceso','La actividad esta en desarrollo');
        $this->insert('Finalizado','La actividad ha finalizado');
        $this->insert('Cancelada','La actividad se ha cancelado');
    }
    private function insert($nombre,$descripcion){
        $estatusProyectoActividad = new EstatusProyectoActividad();
        $estatusProyectoActividad->nombre = $nombre;
        $estatusProyectoActividad->descripcion = $descripcion;
        $estatusProyectoActividad->created_at = now();
        $estatusProyectoActividad->updated_at = now();
        $estatusProyectoActividad->save();
    }
}
