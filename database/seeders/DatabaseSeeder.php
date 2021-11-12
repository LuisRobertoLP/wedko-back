<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([RolesTableSeeder::class]);
        $this->call([UsuarioSeeder::class]);
        $this->call([TelefonoSeeder::class]);
        $this->call([EstatusProyectoSeeder::class]);
        $this->call([ProyectoSeeder::class]);
        $this->call([RoleProyectoSeeder::class]);
        $this->call([UsuarioProyectoSeeder::class]);
        $this->call([ProyectoComentarioSeeder::class]);
        $this->call([EstatusProyectoActividadSeeder::class]);
        $this->call([ProyectoActividadSeeder::class]);
        $this->call([ProyectoActividadComentarioSeeder::class]);
        $this->call([UsuarioProyectoActividadSeeder::class]);

    }
}
