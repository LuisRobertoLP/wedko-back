<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->insert('antonio','hernández','antonio@wedko.com','12341234','Administrador');
        $this->insert('edgar','torres','edgar@wedko.com','12341234','Cliente');
        $this->insert('luis','pineda','luis@wedko.com','12341234','Cliente');
        $this->insert('oscar','escamilla','oscar@wedko.com','12341234','Cliente');
        $this->insert('daniela','hernández','daniela@wedko.com','12341234','Cliente');
        $this->insert('klithiel','ucan','klithiel@wedko.com','12341234','Cliente');

    }
    private function insert($name,$apellidos,$email,$password,$role){
        $user = new User();
        $user->name = $name;
        $user->apellidos = $apellidos;
        $user->imagen = 'imagenes/usuarios/default.png';
        $user->email = $email;
        $user->email_verified_at = now();
        $user->password = Hash::make($password);
        $user->imagen = 'foto_perfil.png';

        $user->created_at = now();
        $user->updated_at = now();
        $user->save();
        $user->assignRole($role);
    }
}
