<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProyectoActividad;

class ProyectoActividadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->insert('actividad sin asignar wedko','descripción de la actividad sin asignar',1,1,'2021-11-09 15:51:20');

        $this->insert('actividad 1.0 desarrollo wedko','descripción de la actividad 1.0',1,2,'2021-11-08 15:51:20');
        $this->insert('actividad 1.1 desarrollo wedko','descripción de la actividad 1.1',1,3,'2021-11-09 15:51:20');
        $this->insert('actividad 1.2 desarrollo wedko','descripción de la actividad 1.2',1,4,'2021-11-10 15:51:20');
        $this->insert('actividad 2.0 diseño wedko','descripción de la actividad 2.0',1,2,'2021-11-11 15:51:20');
        $this->insert('actividad 2.1 diseño wedko','descripción de la actividad 2.1',1,3,'2021-11-12 15:51:20');
        $this->insert('actividad 2.2 diseño wedko','descripción de la actividad 2.2',1,4,'2021-11-13 15:51:20');

    }
    private function insert(
        $nombre,
        $descripcion,
        $proyecto_id,
        $estatus_proyecto_actividad_id,
        $fecha
    ){
        $proyectoActividad = new ProyectoActividad();
        $proyectoActividad->nombre = $nombre;
        $proyectoActividad->descripcion = $descripcion;
        $proyectoActividad->proyecto_id = $proyecto_id;
        $proyectoActividad->fecha = $fecha;
        $proyectoActividad->estatus_proyecto_actividad_id = $estatus_proyecto_actividad_id;
        $proyectoActividad->created_at = now();
        $proyectoActividad->updated_at = now();
        $proyectoActividad->save();
    }
}
