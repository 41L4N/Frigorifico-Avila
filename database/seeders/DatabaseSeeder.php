<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(){

        // Administrador
        $u = new Usuario;
        $u->nombre = "Open";
        $u->apellido = "Skies";
        $u->email = "desarrolloweb@openskie.com";
        $u->password = bcrypt("000000000000000");
        $u->save();
    }
}