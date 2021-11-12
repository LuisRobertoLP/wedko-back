<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

use App\Models\User;
class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $roles = ['Administrador','Cliente'];

        foreach($roles as $role){
        	Role::create(['name' => $role]);
        }   
    }
}
