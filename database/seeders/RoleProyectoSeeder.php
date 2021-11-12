<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoleProyecto;

class RoleProyectoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $roles = ['Supervisor','Desarrollador','Diseñador'];

        foreach($roles as $role){
        	RoleProyecto::create(['nombre' => $role,'descripcion'=>'ninguna']);
        }   
    }
}
