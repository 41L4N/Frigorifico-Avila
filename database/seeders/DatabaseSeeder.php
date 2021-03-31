<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use App\Models\FiltroProducto;

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
        $u->nombre = "Alimentos";
        $u->apellido = "Ávila";
        $u->email = "desarrollo@alimentosavila.com";
        $u->telf = json_encode([
            'codigo' => '58',
            'numero' => '4169227441'
        ]);
        $u->administrador = true;
        $u->password = bcrypt("000000000000000");
        $u->save();

        // Filtros
        foreach ([
            'Aves',
            'Embutidos' => ['Al vacio'],
            'Productos congelados',
            'Vacunos'
        ] as $fp => $opciones) {
            $fp = new FiltroProducto;
            $fp->titulo = (is_array($opciones)) ? $fp : $opciones;
            $fp->save();
            foreach ((is_array($opciones)) ? $opciones : [] as $opcion) {
                $o = new FiltroOpcion;
                $o->titulo = $opcion;
                $o->relacion = $fs->id;
                $o->save();
            }
        }
    }
}