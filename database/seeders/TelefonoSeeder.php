<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Telefono;

class TelefonoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->insert('99111111','descripción',1);
        $this->insert('22222222','descripción1',2);
        $this->insert('12341231','descripción1',2);
        $this->insert('3333333','descripción12',3);
        $this->insert('421412131','descripción12',3);
        $this->insert('99222222','descripción 2',4);
        $this->insert('231241231','descripción 2',4);
        $this->insert('99333333','descripción 3',5);
        $this->insert('51245121','descripción 3',5);
        $this->insert('99444444','descripción 4',6);
        $this->insert('56637544','descripción 4',6);
    }
    private function insert($numero,$descripcion,$usuario_id){
        $telefon = new Telefono();
        $telefon->numero = $numero;
        $telefon->descripcion = $descripcion;
        $telefon->usuario_id = $usuario_id;
        $telefon->created_at = now();
        $telefon->updated_at = now();
        $telefon->save();
    }
}
